<?php
session_start();

function ifUserIsLoggedIn()
{
    if (isset($_SESSION['user_id'])) return true;
    return false;
}

function ifRequestIsPost()
{
    if ($_SERVER['REQUEST_METHOD'] === "POST") return true;
    return false;
}

function flash($name = '', $message = '', $class = 'alert alert-success')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name . "_class"])) {
                unset($_SESSION[$name . "_class"]);
            }
            $_SESSION[$name] = $message;
            $_SESSION[$name . "_class"] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo "<div class='$class' id='msg-flash'>{$_SESSION[$name]}</div>";

            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

function redirect($whereTo)
{
    header("Location: " . URLROOT . "$whereTo");
}

