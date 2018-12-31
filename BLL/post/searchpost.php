<?php
include '../../utilities/session.php';
include '../../utilities/validator.php';
include '../../DAL/post/searchkeyword.php';


if (!empty($_POST["search"])) {

    $search = $_POST["search"];

    $allResultpostlist = array();

    $searchvalue = searchvaliadtor($search);

    $keywords = explode(" ", $searchvalue);

    foreach ($keywords as $keyword) {
        $returnresultlist = searchpostofkey($keyword);

        if (!empty($returnresultlist)) {
            foreach ($returnresultlist as $result) {
                array_push($allResultpostlist, $result);
            }
        } else {
            array_push($allResultpostlist, NULL);
        }
    }

    $search_data = json_encode($allResultpostlist);

    $filename = "search/" . $searchvalue . ".json";

    if (file_put_contents($filename, $search_data)) {
        echo $filename . "file Created";
        header("Location: ../../UI/user/search.php?searchvalue=" . $searchvalue);
    } else {
        echo "there is a error";
    }
} else {
    $_SESSION["error"] = "Search Keyword is Empty or Invalid";
    //header("Location: ../../UI/user/blog.php?type=error");
}

function viewresultpost($allResultpostlist) {
//    echo gettype($allResultpostlist);
//    echo print_r($allResultpostlist);
//    die;
    if (!empty($allResultpostlist)) {
        foreach ($allResultpostlist as $post) {
            ?>
            <div class="blogpost thumbnail">
                <div class="blogpost-header">
                    <h1 class="blogpost-title">
            <?php echo htmlentities($post->posttitle); ?>
                    </h1>
                    <p>
                        Category:
                        <label class="label label-info">
                        <?php echo htmlentities($post->categoryname); ?>
                        </label>
                        <span class="pull-right">
                            Published on : 
                            <?php echo date_format(date_create($post->posttime), "F d, Y"); ?> 
                        </span>
                    </p>
                </div>
                <div class="blogpost-body">
                    <img class="img img-responsive" src="<?php echo "../../postcontent/image/" . $post->image; ?>"/>
                    <div class="caption">
                        <p class="blogpost-description">
            <?php
            $postdescription = str_replace("</p>", "", str_replace("<p>", "", $post->description));
            if (strlen($postdescription) > 200) {
                $postdescription = substr($postdescription, 0, 200) . " ... ";

                echo $postdescription;
            } else {
                echo $postdescription;
            }
            ?>
                            <a class="pull-right" href="detailpost.php?id=<?php echo $post->id; ?>">Read More ....</a>
                        </p>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="blogpost thumbnail">
            <div class="blogpost-header">
                <h1 class="blogpost-title">Empty List</h1>
            </div>
            <div class="blogpost-body">
                <p class="blogpost-description">There is no Post Found...</p> 
            </div>
        </div>
        <?php
    }
}
