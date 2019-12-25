<?php

function create($class, int $times = 1, array $data = [])
{
    return factory($class, $times)->create($data);
}

function make($class, int $times = 1, array $data = [])
{
    return factory($class, $times)->make($data);
}

function raw($class, int $times = 1, array $data = [])
{
    return factory($class, $times)->raw($data)[0];
}
