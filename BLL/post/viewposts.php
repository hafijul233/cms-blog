<?php
include '../../DAL/post/retriveallpost.php';

function getpostlist() {

    $postlist = retriveallposts();

    if (empty($postlist)) {
        ?>
        <div class="blogpost">
            <h2 class="blogpost-title">Empty List</h2>
            <p class="blogpost-description">There is no Post Entered... Please add new post <a href="#">Add ...</a></p>
        </div>
        <?php
    }
    else {
        foreach ($postlist as $post) {
            ?>
            <div class="blogpost thumbnail">
                <div class="blogpost-header">
                    <h1 class="blogpost-title">
                        <?php echo htmlentities($post["title"]); ?>
                    </h1>
                    <p>
                    Category:
                        <label class="label label-info">
                            <?php echo htmlentities($post["categoryname"]); ?>
                        </label>
                    <span class="pull-right">
                        Published on : 
                            <?php echo date_format(date_create($post["createtime"]),"F d, Y"); ?> 
                    </span>
                    </p>
                </div>
                <div class="blogpost-body">
                    <img class="img img-responsive" src="<?php echo "../../postcontent/image/" . $post["image"]; ?>"/>
                    <div class="caption">
                        <div class="blogpost-description"><p>
                            <?php 
                            $postdescription = str_replace("</p>", "", str_replace("<p>","",$post["description"]));
                            if(strlen($postdescription) > 200){
                                $postdescription = substr($postdescription, 0, 200) . " ... ";
                            
                                echo $postdescription;
                            }
                            else {
                                echo $postdescription;
                            }
                            ?>
                                <a class="pull-right" href="detailpost.php?id=<?php echo $post["id"]; ?>">Read More ....</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
