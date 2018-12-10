<?php
       include '../../DAL/category/retrivecategory.php';
       
       function getcategorylist() {
           
            $categorylist = retrivecategory();
            
            if(empty($categorylist)){
                echo "<tr>";
                    echo "<td colspan=4> There are no Category Found</td>";
                echo "</tr>";
            }
            else{
                //`id`, `name`, `categorycreator`, `datetime`, `created`, `modified`, `status`
                foreach ($categorylist as $category) {
                    echo "<tr>";
                    
                        echo "<td>" . $category['id'] . "</td>";
                        echo "<td>" . $category['name'] . "</td>";
                        echo "<td>" . $category['categorycreator'] . "</td>";
                        echo "<td>" . str_replace("-", "/", $category['datetime']) . "</td>";
                    
                        if( $category['status'] == 1)
                            echo "<td>" . "<label class=\"label label-success\">active</div>". "</td>";
                        
                        else if( $category['status'] == 0)
                            echo "<td>" . "<label class=\"label label-danger\">closed</div>". "</td>";
                        
                        else 
                            echo "<td>" . "<label class=\"label label-warning\">unknown</div>". "</td>";
                   
                    echo "</tr>";
                    
                }
            }
        }
       