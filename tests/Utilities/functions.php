<?php

function create($class, array $data = [], int $times = 1)
{
    return factory($class, $times)->create($data);
}

function make($class, array $data = [], int $times = 1)
{
    return factory($class, $times)->make($data);
}

function raw($class, array $data = [], int $times = 1)
{
    return factory($class, $times)->raw($data)[0];
}
