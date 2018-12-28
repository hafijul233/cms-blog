<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>System Login Page</title>
        <style>
            @import "compass/css3";

            .flex-container {
                padding: 0;
                margin: 0;
                list-style: none;

                display: -webkit-box;
                display: -moz-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex;
                align-items: center;
                justify-content: center;

            }

            row{
                width: 100%;
            }

            .flex-item-admin {
                padding: 5px;
                width: 200px;
                height: 550px;
                margin: 10px;
                background: limegreen;
                line-height: 150px;
                color: white;
                font-weight: bold;
                font-size: 3em;
                text-align: center;
                height: 200px;
                border: 3px solid aqua;
            }
            
            .flex-item-user {
                background: yellowgreen;
                padding: 5px;
                width: 200px;
                height: 150px;
                margin: 10px;

                line-height: 150px;
                color: white;
                font-weight: bold;
                font-size: 3em;
                text-align: center;
                border: 3px solid yellow;
            }
            
            
        </style>
    </head>
    <body>
        <div class="flex-container">
            <div class="row">
                <span class="flex-item-admin"><a href="UI/admin/dashboard.php">Admin Dashboard</a></span>
            </div>
            <div class="row">
                <span class="flex-item-user"><a href="UI/user/blog.php">User Dashboard</a></span>
            </div>
        </div>
    </body>
</html>