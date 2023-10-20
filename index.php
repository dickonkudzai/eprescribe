<?php
    session_start();
    if (!$_SESSION['type'])
    {
        # code...
        header("location:login");
    }
    else
    {
        header("location:home/");
    }
