<?php

namespace App\Enums;

enum AssetsFolderEnum: string {

    case PUBLIC_ASSETS            = "assets";
    case STORAGE_ASSETS           = "storage";
    case COIN_LOGO_DIR            = 'crypto';
    case QUICK_EXCHANGE_TNX_IMAGE = "quick_exchange/tnx_images";
    case UPLOAD_ROOT_DIR          = "public/upload";
    case PAYMENT_GATEWAY_DIR      = "gateway";
    case PACKAGE                  = "package";
    case STAKE                  = "stake";
    case PACKAGE_PLACEHOLDER      = "upload/package/package.png";
}