<?php

return [
    // General
    'donation_tags' => '기부 태그',
    'donation_tag' => '기부 태그',
    'manage_donation_tags' => '기부 태그 관리',
    
    // Actions
    'create_donation_tag' => '기부 태그 생성',
    'edit_donation_tag' => '기부 태그 편집',
    'view_donation_tag' => '기부 태그 보기',
    'delete_donation_tag' => '기부 태그 삭제',
    'add_new_tag' => '새 태그 추가',
    
    // Fields
    'name' => '이름',
    'slug' => '슬러그',
    'description' => '설명',
    'color' => '색상',
    'icon' => '아이콘',
    'status' => '상태',
    'sort_order' => '정렬 순서',
    'created_by' => '생성자',
    'created_at' => '생성일',
    'updated_at' => '수정일',
    
    // Placeholders
    'enter_tag_name' => '태그 이름을 입력하세요',
    'enter_description' => '설명을 입력하세요 (선택사항)',
    'choose_color' => '색상을 선택하세요',
    'select_icon' => '아이콘을 선택하세요 (선택사항)',
    'enter_sort_order' => '정렬 순서를 입력하세요',
    
    // Help text
    'name_help' => '이 기부 태그의 표시 이름',
    'slug_help' => '이름의 URL 친화적 버전 (비어있으면 자동 생성)',
    'description_help' => '이 태그에 대한 선택적 설명',
    'color_help' => '이 태그를 표시하는 데 사용되는 색상 (hex 형식)',
    'icon_help' => 'Tabler 아이콘 클래스 (예: ti-heart, ti-star)',
    'sort_order_help' => '낮은 숫자가 목록에서 먼저 나타납니다',
    
    // Status
    'active' => '활성',
    'inactive' => '비활성',
    'is_active' => '활성 상태',
    
    // Messages
    'created_successfully' => '기부 태그가 성공적으로 생성되었습니다',
    'updated_successfully' => '기부 태그가 성공적으로 업데이트되었습니다',
    'deleted_successfully' => '기부 태그가 성공적으로 삭제되었습니다',
    'no_tags_found' => '기부 태그를 찾을 수 없습니다',
    
    // Confirmations
    'confirm_delete' => '이 기부 태그를 삭제하시겠습니까?',
    'delete_warning' => '이 작업은 되돌릴 수 없습니다.',
    
    // Table headers
    'tag_name' => '태그 이름',
    'icon_preview' => '아이콘',
    'creator' => '생성자',
    'actions' => '작업',
    
    // Validation
    'name_required' => '태그 이름은 필수입니다',
    'name_max' => '태그 이름은 255자를 초과할 수 없습니다',
    'slug_unique' => '이 슬러그는 이미 사용 중입니다',
    'color_format' => '색상은 hex 형식이어야 합니다 (예: #3b82f6)',
    'sort_order_min' => '정렬 순서는 최소 0이어야 합니다',
];
