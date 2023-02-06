<?php

namespace App\Enums;

enum HashTypeEnum : string {
    case Verify = 'verify_email';
    case Recovery = 'password_recovery';
    case ChangeEmail = 'change_email';
}