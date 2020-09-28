from random import randint
from telegram.ext import Updater, CommandHandler, MessageHandler, ConversationHandler, CallbackQueryHandler, Filters
from telegram import InlineKeyboardMarkup, InlineKeyboardButton
from telegram import KeyboardButton, ReplyKeyboardMarkup, ReplyKeyboardRemove
from telegram import Bot
from telegram import ParseMode
from telegram import error as Error
import os
import logging
from mindset import ListDrawing
import numpy as np
import configparser


# Config
config = configparser.ConfigParser()
config.read('config.ini')


state = -1
_deploy_mode = 2 # 0: polling , 1: webhook - localhost , 2: webhook - heroku


PORT = int(os.environ.get('PORT', 5000))


update_id = None

# Enable logging
logging.basicConfig(format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',
                    level=logging.INFO)
logger = logging.getLogger(__name__)

APP_NAME = config['TELEGRAM']['APP_NAME']
TOKEN = config['TELEGRAM']['ACCESS_TOKEN']
WEBHOOK_URL = config['TELEGRAM']['WEBHOOK_URL']

# State

SIGNIN, GOBACK, SELECT, DRAWIT, CREATE, UPDATE, RATING, RATING_2, RENAME, RENAME_2, DELETE, WEIGHT  = range(12)

system = None
DB_List = ['drplus','roboconTea','testcase','HKSTP']
rename_buffer = {'ori':'' , 'new':''}

# Menu
input_keyboard = [['去邊到食'],['新增餐廳','刪除餐廳'],['調整評分','調整機率'],['更改名稱','查看參數']]
markup = ReplyKeyboardMarkup(input_keyboard, one_time_keyboard=True)
restaurant_keyboard = []
r_markup = ReplyKeyboardMarkup(restaurant_keyboard, one_time_keyboard=True)
# Rating
rating_key = [[
    InlineKeyboardButton('1', callback_data = '1'),
    InlineKeyboardButton('2', callback_data = '2'),
    InlineKeyboardButton('3', callback_data = '3'),
    InlineKeyboardButton('4', callback_data = '4'),
    InlineKeyboardButton('5', callback_data = '5'),
]]
rating_markup = InlineKeyboardMarkup(rating_key)
def sign_in(bot, update):
    global update_id
    update.message.reply_text('請輸入資料庫:')
    return SIGNIN

def select(bot, update): # main menu
    global DB_List
    global system
    global restaurant_keyboard
    global r_markup
    if update.message.text not in DB_List:
        update.message.reply_text('資料庫不存在')
        update.message.reply_text('請輸入資料庫:')
        return GOBACK
    system = ListDrawing(update.message.text, True)
    restaurant_keyboard = np.reshape(list(system.restaurant_list.keys()),(system.list_size,1)).tolist()
    r_markup = ReplyKeyboardMarkup(restaurant_keyboard, one_time_keyboard=True)
    update.message.reply_text('你想...?',reply_markup = markup)
    
    return SELECT
def draw_it(bot, update):
    global system
    update.message.reply_text('結果: '+ system.draw())
    update.message.reply_text('你想...?',reply_markup = markup)
    return SELECT

def create(bot, update):
    update.message.reply_text("新增餐廳名稱?")
    return CREATE
def create_2(bot, update):
    global system
    global restaurant_keyboard
    global r_markup
    new_rest = update.message.text
    status = system.create(new_rest)
    if status == 1:
        update.message.reply_text("已新增餐廳...")
        restaurant_keyboard.append([new_rest])
        r_markup = ReplyKeyboardMarkup(restaurant_keyboard, one_time_keyboard=True)
        update.message.reply_text('你想...?',reply_markup = markup)
    else:
        update.message.reply_text("餐廳名稱已重複...")
        update.message.reply_text('你想...?',reply_markup = markup)

    return SELECT

r_arr= np.array([])
r_obj = {}
r_ptr = 0

def update(bot, update):
    global system
    global r_ptr
    global r_arr
    global r_obj
    
    
    if r_ptr != 0:
        r_arr = np.append(r_arr,float(update.message.text))
        

    if r_ptr < system.list_size:     
        update.message.reply_text(list(system.restaurant_list.keys())[r_ptr] + " 的機率？")
        r_ptr += 1
        return UPDATE

    # update all weight
    else:
        r_arr *= 1 / np.sum(list(r_arr))
        
        r_obj = dict(zip(list(system.restaurant_list.keys()),list(r_arr)))
        system.update(r_obj)
        update.message.reply_text("餐廳機率已更新...")
        update.message.reply_text('你想...?',reply_markup = markup)
        return SELECT

selected = ""
def rating(bot, update):
    # your bot can receive updates without messages
    update.message.reply_text("餐廳名稱?",reply_markup = r_markup)
    return RATING

def rating_2(bot, update):
    global selected
    selected = update.message.text
    update.message.reply_text("餐廳評級？(最低1分，最高5分)",reply_markup = rating_markup)
    return RATING_2

def rating_3(bot, update):
    global system
    sr = update.callback_query.data
    try:
        status = system.rating(selected,int(sr))
        if status == 1:
            update.callback_query.edit_message_text("已完成評價...")
        elif status == 0:
            update.callback_query.edit_message_text("餐廳評級不是1至5...")
        elif status == -1:
            update.callback_query.edit_message_text("餐廳名稱不存在...")
        else:
            update.callback_query.edit_message_text("Unknown Error...")
        update.effective_message.reply_text("你想...",reply_markup=markup)
    except Exception as e:
        print(e)

    return SELECT


def delete(bot, update):
    update.message.reply_text("刪除的餐廳名稱?",reply_markup = r_markup)
    return DELETE

def delete_2(bot, update):
    global system
    global r_markup
    global restaurant_keyboard
    status = system.delete(update.message.text)
    if status == 1: # the result of delete
        restaurant_keyboard.remove([update.message.text])
        r_markup = ReplyKeyboardMarkup(restaurant_keyboard, one_time_keyboard=True)
        update.message.reply_text("已刪除該餐廳...")
    else:
        update.message.reply_text("餐廳名稱不存在...")
    update.message.reply_text('你想...?',reply_markup = markup)
    return SELECT

def rename(bot, update):
    update.message.reply_text("舊有餐廳名稱?",reply_markup = r_markup)
    return RENAME

def rename_2(bot, update):
    global rename_buffer
    rename_buffer['ori'] = update.message.text
    update.message.reply_text("改為?")
    return RENAME_2

def rename_3(bot, update):
    global system
    global rename_buffer
    global restaurant_keyboard
    global r_markup
    rename_buffer['new'] = update.message.text
    status = system.rename(rename_buffer['ori'],rename_buffer['new'])
    if status == 1:
        restaurant_keyboard = np.reshape(list(system.restaurant_list.keys()),(system.list_size,1)).tolist()
        r_markup = ReplyKeyboardMarkup(restaurant_keyboard, one_time_keyboard=True)
        update.message.reply_text("已重新命名...")
    elif status == 0:
        update.message.reply_text("餐廳名稱已重複...")
    elif status == -1:
        update.message.reply_text("餐廳名稱不存在...")
    else:
        update.message.reply_text("unknown Error...")
    update.message.reply_text('你想...?',reply_markup= markup)
    return SELECT

def record(bot, update):
    global system 
    for key in list(system.restaurant_list.keys()):
        update.message.reply_text(
            "<b>名稱:</b>"+key+
            "\n<b>機率:</b>"+str(round(system.restaurant_list[key],5))+
            "\n<b>評分:</b>"+str(system.rating_list[key]),
            parse_mode=ParseMode.HTML)
    
    print("DEBUG SUM: "+str(np.sum(list(system.restaurant_list.values()))))
    update.message.reply_text('你想...?',reply_markup= markup)
    return SELECT
def finish(bot, update):
    update.message.reply_text('再見')
    return ConversationHandler.END
def error(update, context):
    """Log Errors caused by Updates."""
    logger.warning('Update "%s" caused error "%s"', update, context.error)

def main():
    
    try:
        update_id = Bot(TOKEN).get_updates()[0].update_id
    except IndexError:
        update_id = None
    except Error.Conflict:
        update_id = None

    logging.basicConfig(format='%(asctime)s - %(name)s - %(levelname)s - %(message)s', level=logging.INFO)
    updater = Updater(TOKEN)
    dp = updater.dispatcher
    conv_handler = ConversationHandler(
        entry_points = [CommandHandler('start',sign_in )],
        states={
            SIGNIN:[MessageHandler(Filters.regex('^[0-9a-zA-Z]+$'),select )],
            GOBACK:[MessageHandler(Filters.regex('^[0-9a-zA-Z]+$'),select)],
            SELECT:[
                MessageHandler(Filters.regex('^去邊到食$'), draw_it),
                MessageHandler(Filters.regex('^新增餐廳$'), create ),
                MessageHandler(Filters.regex('^刪除餐廳$'), delete ),
                MessageHandler(Filters.regex('^調整評分$'), rating ),
                MessageHandler(Filters.regex('^調整機率$'), update ),            
                MessageHandler(Filters.regex('^更改名稱$'), rename ),
                MessageHandler(Filters.regex('^查看參數$'), record ),
            ],
            CREATE  :[MessageHandler(Filters.text, create_2)],
            DELETE  :[MessageHandler(Filters.text, delete_2)],
            UPDATE  :[MessageHandler(Filters.text, update)  ],
            RENAME  :[MessageHandler(Filters.text, rename_2)],
            RENAME_2:[MessageHandler(Filters.text, rename_3)],
            RATING  :[MessageHandler(Filters.text, rating_2)],
            RATING_2:[CallbackQueryHandler(rating_3)]
        
        },
        fallbacks=[CommandHandler('done', finish)]
    )
    dp.add_handler(conv_handler)
    # dp.add_handler(CallbackQueryHandler(rating_3))
    if _deploy_mode == 0:
        updater.start_polling()
    elif _deploy_mode == 1:
        updater.start_webhook(listen='127.0.0.1',port=PORT, url_path=TOKEN)
        updater.bot.set_webhook(webhook_url="127.0.0.1")
    elif _deploy_mode == 2:
        updater.start_webhook(listen='0.0.0.0',port=PORT, url_path=TOKEN)
        updater.bot.set_webhook(WEBHOOK_URL + TOKEN)
    else:
        print("Deploy error...")
    updater.idle()

if __name__ == '__main__':
    main()