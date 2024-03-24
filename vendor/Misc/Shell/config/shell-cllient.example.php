<?php
return [
    "some-env" => [
        "auth" => [
            "url" => "https://localhost.com/api/v01/auth/login",
            "username" => "admin",
            "password" => "pwd1234"
        ],
        "shell" => [
            "url" => "https://localhost.com/api/v01/tools/cmds",
            "sectoken" => hash("sha256", "xxx-yyyy"),
        ],
        "shell" => [
            "url" => "https://localhost.com/api/v01/tools/redis",
            "sectoken" => hash("sha256", "aaa-bbbb"),
        ],
    ]
];