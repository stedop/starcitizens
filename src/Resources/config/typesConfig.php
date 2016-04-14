<?php


return [
    "accounts" => [
        "base_action" => "full_profile",
        "actions" => [
            "full_profile" => '\ExtensionExample',
            "threads" => ['\Thread', '', 'thread_id'],
            "posts" => ['\Post', 'post', 'post_id'],
        ]
    ],
    "organizations" => [
        "base_action" => "single_organization",
        "actions" => [
            "single_organization" => '\Organisation',
            "organization_members" => ['\OrgMember', '', 'handle']
        ]
    ],
];