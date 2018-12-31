<?php
if(session_status()>1){
    session_destroy();
    session_start();
}
else {
    session_start();
}


