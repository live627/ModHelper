<?php

// Add a function for integration hook.
function add_integration_function($hook, $function, $permanent = true)
{
    global $modSettings;

    // Make current function list usable.
    $functions = empty($modSettings[$hook]) ? array() : explode(',', $modSettings[$hook]);

    // Do nothing, if it's already there.
    if (in_array($function, $functions))
        return;

    $functions[] = $function;
    $modSettings[$hook] = implode(',', $functions);
}

// Remove an integration hook function.
function remove_integration_function($hook, $function)
{
    global $modSettings;

    // Turn the function list into something usable.
    $functions = empty($modSettings[$hook]) ? array() : explode(',', $modSettings[$hook]);

    // You can only remove it if it's available.
    if (!in_array($function, $functions))
        return;

    $functions = array_diff($functions, array($function));
    $modSettings[$hook] = implode(',', $functions);
}
