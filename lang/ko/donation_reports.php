<?php

return [
    // Page titles
    'donation_reports' => '기부 보고서',
    'manage_donation_reports' => '기부 보고서 관리',
    'create_donation_report' => '기부 보고서 생성',
    'edit_donation_report' => '기부 보고서 편집',
    'view_donation_report' => '기부 보고서 보기',
    'donation_report_details' => '기부 보고서 상세',

    // Form fields
    'campaign' => '캠페인',
    'select_campaign' => '캠페인 선택',
    'institution_name' => '기관명',
    'contact_person' => '담당자',
    'contact_email' => '연락처 이메일',
    'contact_phone' => '연락처 전화',
    'distributed_amount' => '배분 금액',
    'distribution_date' => '배분 날짜',
    'description' => '설명',
    'beneficiaries' => '수혜자',
    'status' => '상태',
    'evidence_file' => '증빙 파일',
    'current_evidence_file' => '현재 증빙 파일',
    'replace_evidence_file' => '증빙 파일 교체',
    'notes' => '메모',
    'created_by' => '생성자',
    'verified_by' => '검증자',
    'verified_at' => '검증 일시',
    'report_id' => '보고서 ID',

    // Help texts
    'institution_name_help' => '기부금을 배분한 기관의 이름',
    'distributed_amount_help' => '수혜자에게 배분된 금액',
    'distribution_date_help' => '배분이 이루어진 날짜 (미래 날짜 불가)',
    'description_help' => '배분 활동에 대한 상세 설명',
    'beneficiaries_help' => '기부금을 받은 사람들에 대한 정보',
    'evidence_file_help' => '지원 문서 업로드 (PDF, DOC, DOCX, JPG, PNG - 최대 5MB)',
    'notes_help' => '이 보고서에 대한 추가 메모나 코멘트',

    // Actions
    'add_new_report' => '새 보고서 추가',
    'create_report' => '보고서 생성',
    'update_report' => '보고서 업데이트',
    'verify' => '검증',
    'reject' => '거부',
    'verified' => '검증됨',
    'rejected' => '거부됨',

    // Status messages
    'created_successfully' => '기부 보고서가 성공적으로 생성되었습니다',
    'updated_successfully' => '기부 보고서가 성공적으로 업데이트되었습니다',
    'deleted_successfully' => '기부 보고서가 성공적으로 삭제되었습니다',
    'verified_successfully' => '기부 보고서가 성공적으로 검증되었습니다',
    'rejected_successfully' => '기부 보고서가 성공적으로 거부되었습니다',

    // Confirmations
    'confirm_delete_text' => '이 기부 보고서를 삭제하시겠습니까',
    'confirm_verify' => '보고서 검증',
    'confirm_verify_text' => '이 기부 보고서를 검증하시겠습니까?',
    'confirm_reject' => '보고서 거부',
    'confirm_reject_text' => '이 기부 보고서를 거부하시겠습니까?',
    'rejection_notes' => '거부 사유',
    'rejection_notes_placeholder' => '거부 사유를 입력해주세요...',
    'rejection_notes_required' => '거부 사유는 필수입니다',

    // Error messages
    'cannot_edit_verified' => '검증되거나 거부된 보고서는 편집할 수 없습니다',
    'cannot_verify' => '이 보고서를 검증할 수 없습니다',
    'cannot_reject' => '이 보고서를 거부할 수 없습니다',

    // Validation messages
    'campaign_required' => '캠페인은 필수입니다',
    'campaign_exists' => '선택한 캠페인이 존재하지 않습니다',
    'institution_name_required' => '기관명은 필수입니다',
    'institution_name_max' => '기관명은 255자를 초과할 수 없습니다',
    'contact_email_email' => '연락처 이메일은 유효한 이메일 주소여야 합니다',
    'distributed_amount_required' => '배분 금액은 필수입니다',
    'distributed_amount_numeric' => '배분 금액은 숫자여야 합니다',
    'distributed_amount_min' => '배분 금액은 최소 0이어야 합니다',
    'distributed_amount_max' => '배분 금액이 너무 큽니다',
    'distribution_date_required' => '배분 날짜는 필수입니다',
    'distribution_date_date' => '배분 날짜는 유효한 날짜여야 합니다',
    'distribution_date_before_or_equal' => '배분 날짜는 미래일 수 없습니다',
    'evidence_file_file' => '증빙 파일은 유효한 파일이어야 합니다',
    'evidence_file_mimes' => '증빙 파일은 PDF, DOC, DOCX, JPG, JPEG, PNG 형식이어야 합니다',
    'evidence_file_max' => '증빙 파일은 5MB를 초과할 수 없습니다',

    // Information sections
    'campaign_information' => '캠페인 정보',
    'institution_information' => '기관 정보',
    'distribution_information' => '배분 정보',
    'verification_information' => '검증 정보',

    // File handling
    'click_to_view' => '파일 보기',
    'click_to_download' => '파일 다운로드',

    // Campaign show view
    'no_reports' => '아직 보고서 없음',
    'no_reports_description' => '이 캠페인에 대한 기부 보고서가 아직 제출되지 않았습니다.',
    'add_first_report' => '첫 번째 보고서 추가',
    'not_found' => '보고서를 찾을 수 없음',

    // Image management
    'images' => '이미지',
    'report_details' => '보고서 상세정보',
    'details_tab_description' => '이 기부 보고서에 대한 자세한 정보를 확인하세요.',
    'current_images' => '현재 이미지',
    'no_images' => '이미지 없음',
    'add_new_images' => '새 이미지 추가',
    'select_images' => '이미지 선택',
    'images_help' => '이미지 업로드 (JPG, PNG, GIF - 이미지당 최대 5MB, 최대 10개 이미지)',
    'upload_images' => '이미지 업로드',
    'primary_image' => '기본',
    'set_as_primary' => '기본으로 설정',
    'no_alt_text' => '설명 없음',
    'images_uploaded_successfully' => '이미지가 성공적으로 업로드되었습니다',
    'image_deleted_successfully' => '이미지가 성공적으로 삭제되었습니다',
    'primary_image_set_successfully' => '기본 이미지가 성공적으로 설정되었습니다',
    'confirm_delete_image' => '이 이미지를 삭제하시겠습니까?',
];
