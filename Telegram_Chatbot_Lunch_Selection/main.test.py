from mindset import ListDrawing
print("======================================================")
print(" ● 去邊到？食乜柒？ ver 1.0")
print("======================================================")
table = input("請輸入資料庫:")
system = ListDrawing(table)
select = ''

while select != '0' :
    print("------------------------------------------------------")
    print("你想？")
    print("(1) 去邊到食")
    print("(2) 新餐廳資料")
    print("(3) 改餐廳機率")
    print("(4) 評餐廳品質")
    print("(5) 改餐廳名稱")
    print("(6) 刪餐廳資料")
    print("(7) 查餐廳比重")

    select = input('選擇:(輸入數字)')
    if select == '1':
        print(system.draw())
    if select == '2':
        r_name = input("新增餐廳名稱?")
        status = system.create(r_name)
        if status == 1:
            print("已新增餐廳...")
        else:
            print("餐廳名稱已重複...")
    if select == '3':
        total_weight = 1
        while total_weight != 0:
            update_weights = {}
            total_weight = 1
            print("全部餐廳為:")
            print(system.restaurant_list.keys())
            for k in system.restaurant_list.keys():
                weight = input(k+" 的機率？(剩餘:"+str(total_weight)+")\t")
                total_weight -= round(float(weight),6)
                total_weight = round(total_weight,6)
                if total_weight < 0:
                    print("機率分配錯誤...")
                    break
                update_weights[k] = round(float(weight),6)
            if total_weight > 0:
                print("機率分配錯誤...")
        status = system.update(update_weights)
        if status == 1:
            print("餐廳機率已更新...")
    if select == '4':
        tar_rest = input("餐廳名稱？")
        tar_rate = int(input("餐廳評級？(最低1分，最高5分)"))
        status = system.rating(tar_rest, tar_rate)
        if status == 1:
            print("已完成評價...")
        elif status == 0:
            print("餐廳評級不是1至5...")
        elif status == -1:
            print("餐廳名稱不存在...")
        else:
            print("Unknown Error...")
    if select == '5':
        original =  input("舊有餐廳名稱?")
        new = input("改為?")
        status = system.rename(original,new)
        if status == 1:
            print("已重新命名...")
        elif status == 0:
            print("餐廳名稱已重複...")
        elif status == -1:
            print("餐廳名稱不存在...")
        else:
            print("unknown Error...")
    if select == '6':
        rest = input("刪除的餐廳名稱?")
        status = system.delete(rest)
        if status == 1:
            print("已刪除該餐廳...")
        elif status == 0:
            print("餐廳名稱不存在...")
        else:
            print("unknown Error...")
    if select == '7':
        print("餐廳名稱",end="\t\t")
        for r in system.restaurant_list.keys():
            print(r,end="\t")
        print("")
        print("餐廳機率",end="\t\t")
        for r in system.restaurant_list.values():
            print(round(r,3),end="\t")
        print("")
        print("餐廳評分",end="\t\t")
        for r in system.rating_list.values():
            print(r,end="\t")
        print("")

