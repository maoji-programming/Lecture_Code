<!--
/////////////////////////////////////////////////////////////
/* search_header.`php from CSCI3100 group 15
   03-05-2019

   Purpose: Header embeded in some page like index,search_content ,etc
            Provide interface for seraching content
   Module used by some page
   Included used by some page
*/
////////////////////////////////////////////////////////////
-->
<div class="jumbotron jumbotron-fluid jumbotron-custom-img">
  <div class="container">
    <p style="color: rgba(255,255,255,.9)">
      <font face="Economica, sans-serif" size="6"><b>The Source Library for Secondary Students</b></font>
    </p>
    <p style="color: rgba(255,255,255,.9)">
      <font face="Economica, sans-serif" size="7">A</font><font face="Economica, sans-serif" size="6">cademic</font>
      <font face="Economica, sans-serif" size="7">R</font><font face="Economica, sans-serif" size="6">esource</font>
      <font face="Economica, sans-serif" size="7">M</font><font face="Economica, sans-serif" size="6">aster</font>
    </p>

    <!--searching bar-->
    <form method="post" class="card card-sm"  enctype="multipart/form-data">
      <div class="card-body row no-gutters align-items-center">

          <div class="col-auto">
            <i class="fa fa-search" style="color:#45877b; font-size: xx-large"></i>&ensp;
          </div>
          <div class="col">
            <input class="form-control form-control-lg form-control-borderless" name ="search_content" type="text" placeholder="Find Resources!">
          </div>
          <div class="col-auto">
            <button class="btn btn-lg btn-secondary" name="search_btn" type="submit">Search</button>
          </div>

      </div>
      <div class = "container">
        <div class="form-group row no-gutters align-items-left">
          <label for="inputPassword" class="col-sm-2 col-form-label"><b>Type of Material:</b></label>
          <select class="col-sm-10" id="stype" name='category'>
          <option value="All">All</option>
          <option value="exercise">Exercise</option>
          <option value="Pastpaper">Pastpaper</option>
          <option value="notes">Notes</option>
          <option value="reading">Reading</option>
          <option value="textbook">Textbook</option>
          </select>
        </div>
      </form>
      </div>
    <!--end of searching bar-->

  </div>
</div>
<?php
    if (isset($_POST['search_btn'])){ // case of search button is clicked
      $menu = $_POST['search_content'];
      $search_content = "";
      $srch_exploded = explode(" ", $menu);
      $x = 0;
      foreach($srch_exploded as $srch_each)
      {
        $x++;

        if($x==1)
        {
          $search_content .="$srch_each";
        }
        else
        {
          $search_content .="+$srch_each"; // padding '+' to replace ' '

        }
      }

        echo "<script>
          window.location.href='result.php?search_content=".$search_content."&category=".$_POST['category']."';
          </script>";


    }
?>
