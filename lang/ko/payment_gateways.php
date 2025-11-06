<?php

return [
    // General
    'payment_gateways' => '결제 게이트웨이',
    'payment_gateway' => '결제 게이트웨이',
    'create_title' => '결제 게이트웨이 생성',
    'edit_title' => '결제 게이트웨이 편집',
    'view_title' => '결제 게이트웨이 상세',
    'list_title' => '결제 게이트웨이',

    // Fields
    'name' => '게이트웨이 이름',
    'provider' => '제공업체',
    'api_key' => 'API 키',
    'secret_key' => '시크릿 키',
    'webhook_secret' => '웹훅 시크릿',
    'additional_config' => '추가 설정',
    'is_active' => '상태',
    'is_sandbox' => '모드',
    'description' => '설명',
    'creator' => '생성자',

    // Provider options
    'provider_midtrans' => 'Midtrans',
    'provider_stripe' => 'Stripe',
    'provider_toss' => 'Toss Payments',

    // Status options
    'sandbox' => '샌드박스',
    'production' => '프로덕션',
    'configured' => '설정됨',
    'not_configured' => '설정되지 않음',

    // Placeholders
    'name_placeholder' => '게이트웨이 이름을 입력하세요...',
    'api_key_placeholder' => 'API 키를 입력하세요...',
    'secret_key_placeholder' => '시크릿 키를 입력하세요...',
    'webhook_secret_placeholder' => '웹훅 시크릿을 입력하세요...',
    'description_placeholder' => '게이트웨이 설명을 입력하세요...',

    // Help text
    'name_help' => '이 결제 게이트웨이의 설명적인 이름을 입력하세요',
    'provider_help' => '-- 제공업체 선택 --',
    'api_key_help' => '결제 게이트웨이 제공업체의 API 키',
    'secret_key_help' => '결제 게이트웨이 제공업체의 시크릿 키',
    'webhook_secret_help' => '안전한 통신을 위한 웹훅 시크릿',
    'is_active_help' => '이 결제 게이트웨이를 활성화하거나 비활성화합니다',
    'is_sandbox_help' => '테스트를 위해 샌드박스 모드를 사용합니다',
    'description_help' => '이 게이트웨이 설정에 대한 선택적 설명',
    'additional_config_help' => 'JSON 형식의 추가 설정',

    // Validation messages
    'name_required' => '게이트웨이 이름은 필수입니다',
    'name_max' => '게이트웨이 이름은 255자를 초과할 수 없습니다',
    'provider_required' => '제공업체는 필수입니다',
    'provider_invalid' => '선택된 제공업체가 유효하지 않습니다',
    'api_key_max' => 'API 키는 1000자를 초과할 수 없습니다',
    'secret_key_max' => '시크릿 키는 1000자를 초과할 수 없습니다',
    'webhook_secret_max' => '웹훅 시크릿은 1000자를 초과할 수 없습니다',
    'additional_config_array' => '추가 설정은 유효한 JSON이어야 합니다',
    'is_active_boolean' => '상태는 true 또는 false여야 합니다',
    'is_sandbox_boolean' => '모드는 true 또는 false여야 합니다',
    'description_max' => '설명은 1000자를 초과할 수 없습니다',

    // Success messages
    'created_successfully' => '결제 게이트웨이가 성공적으로 생성되었습니다',
    'updated_successfully' => '결제 게이트웨이가 성공적으로 업데이트되었습니다',
    'deleted_successfully' => '결제 게이트웨이가 성공적으로 삭제되었습니다',

    // Info messages
    'not_set' => '설정되지 않음',
    'connection_successful' => '연결 테스트 성공',
    'connection_failed' => '연결 테스트 실패',

    // DataTable columns
    'dt_name' => '이름',
    'dt_provider' => '제공업체',
    'dt_status' => '상태',
    'dt_mode' => '모드',
    'dt_configured' => '설정',
    'dt_creator' => '생성자',
    'dt_created_at' => '생성일',
    'dt_actions' => '작업',

    // Security
    'masked_key' => '키는 보안을 위해 암호화되고 마스킹됩니다',
    'test_connection' => '연결 테스트',
];
