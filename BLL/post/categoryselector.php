<?php
       include '../../DAL/category/retrivecategory.php';
       
       function getcategoryoptions() {
           
            $categorylist = retrivecategory();
            
            if(empty($categorylist)){
                echo "<option value = \"N/A\"> There are no Category Found</option>";
            }
            else{
                //`id`, `name`, `categorycreator`, `datetime`, `created`, `modified`, `status`
                foreach ($categorylist as $category) {
                    echo "<option value = \"". $category["id"] . "\">" . $category["name"] . "</option>\n";
                }
            }
        }
       