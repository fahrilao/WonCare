<?php

return [
    // General
    'donation_campaigns' => '기부 캠페인',
    'donation_campaign' => '기부 캠페인',
    'create_title' => '기부 캠페인 생성',
    'edit_title' => '기부 캠페인 편집',
    'view_title' => '기부 캠페인 상세',
    'list_title' => '기부 캠페인',

    // Fields
    'title' => '제목',
    'description' => '설명',
    'goal_amount' => '목표 금액',
    'collected_amount' => '모금된 금액',
    'remaining_amount' => '남은 금액',
    'start_date' => '시작일',
    'end_date' => '종료일',
    'status' => '상태',
    'image' => '캠페인 이미지',
    'creator' => '생성자',
    'progress' => '진행률',

    // Status options
    'status_draft' => '초안',
    'status_active' => '활성',
    'status_completed' => '완료',
    'status_cancelled' => '취소됨',

    // Placeholders
    'title_placeholder' => '캠페인 제목을 입력하세요...',
    'description_placeholder' => '캠페인 설명을 입력하세요...',
    'goal_amount_placeholder' => '0.00',

    // Help text
    'title_help' => '명확하고 매력적인 캠페인 제목을 입력하세요',
    'description_help' => '이 캠페인의 목적과 목표를 설명하세요',
    'goal_amount_help' => '이 캠페인을 위해 모금할 목표 금액',
    'start_date_help' => '캠페인이 기부를 받기 시작할 날짜',
    'end_date_help' => '캠페인이 종료될 날짜 (선택사항)',
    'status_help' => '-- 선택하세요 --',
    'image_help' => '캠페인용 이미지 업로드 (선택사항)',

    // Validation messages
    'title_required' => '캠페인 제목은 필수입니다',
    'title_max' => '캠페인 제목은 255자를 초과할 수 없습니다',
    'goal_amount_required' => '목표 금액은 필수입니다',
    'goal_amount_numeric' => '목표 금액은 숫자여야 합니다',
    'goal_amount_min' => '목표 금액은 최소 0이어야 합니다',
    'goal_amount_max' => '목표 금액이 너무 큽니다',
    'start_date_required' => '시작일은 필수입니다',
    'start_date_date' => '시작일은 유효한 날짜여야 합니다',
    'start_date_after_or_equal' => '시작일은 오늘 이후여야 합니다',
    'end_date_date' => '종료일은 유효한 날짜여야 합니다',
    'end_date_after' => '종료일은 시작일 이후여야 합니다',
    'status_required' => '상태는 필수입니다',
    'status_in' => '선택한 상태가 유효하지 않습니다',
    'image_image' => '파일은 이미지여야 합니다',
    'image_mimes' => '이미지는 jpeg, png, jpg, gif 형식이어야 합니다',
    'image_max' => '이미지는 2MB를 초과할 수 없습니다',

    // Success messages
    'created_successfully' => '기부 캠페인이 성공적으로 생성되었습니다',
    'updated_successfully' => '기부 캠페인이 성공적으로 업데이트되었습니다',
    'deleted_successfully' => '기부 캠페인이 성공적으로 삭제되었습니다',

    // Info messages
    'current_image' => '현재 이미지',
    'unlimited_duration' => '종료일이 설정되지 않음',

    // DataTable columns
    'dt_title' => '제목',
    'dt_goal_amount' => '목표',
    'dt_collected_amount' => '모금액',
    'dt_progress' => '진행률',
    'dt_status' => '상태',
    'dt_creator' => '생성자',
    'dt_created_at' => '생성일',
    'dt_actions' => '작업',
];
