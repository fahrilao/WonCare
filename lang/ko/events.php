<?php

return [
  'title' => '이벤트 & 활동',
  'subtitle' => '이벤트 캘린더 & 활동 관리',
  'create_title' => '이벤트 생성',
  'edit_title' => '이벤트 수정',
  'detail_title' => '이벤트 상세',
  'rsvp_title' => '이벤트 참석자 (RSVP)',

  'fields' => [
    'title' => '이벤트 제목',
    'description' => '설명',
    'type' => '이벤트 유형',
    'location' => '위치',
    'meeting_link' => '미팅 링크 (Zoom/온라인)',
    'start_datetime' => '시작 날짜 & 시간',
    'end_datetime' => '종료 날짜 & 시간',
    'max_participants' => '최대 참가자',
    'status' => '상태',
    'banner_image' => '배너 이미지',
    'require_rsvp' => 'RSVP 필요',
    'send_reminder' => '알림 전송',
    'reminder_hours_before' => '이벤트 전 알림 시간',
    'notes' => '메모',
    'participants' => '참가자',
    'date_range' => '날짜 & 시간',
  ],

  'types' => [
    'offline' => '오프라인 (대면 모임)',
    'online' => '온라인 (Zoom 미팅)',
  ],

  'statuses' => [
    'draft' => '초안',
    'published' => '게시됨',
    'cancelled' => '취소됨',
    'completed' => '완료됨',
  ],

  'rsvp' => [
    'name' => '이름',
    'email' => '이메일',
    'phone' => '전화번호',
    'status' => '상태',
    'notes' => '메모',
    'registered_at' => '등록일',
    'attended_at' => '참석일',
    'reminder_sent' => '알림 전송됨',
    'mark_attended' => '참석 표시',
    'statuses' => [
      'pending' => '대기 중',
      'confirmed' => '확인됨',
      'cancelled' => '취소됨',
      'attended' => '참석함',
    ],
  ],

  'documentation' => [
    'title' => '이벤트 문서',
    'upload' => '사진/비디오 업로드',
    'type' => '유형',
    'file' => '파일',
    'photo' => '사진',
    'video' => '비디오',
    'description' => '설명',
  ],

  'reminders' => [
    'send_all' => '모두에게 알림 전송',
    'send_success' => ':count명의 참석자에게 알림이 전송되었습니다',
    'email_sent' => '이메일 알림 전송됨',
    'whatsapp_sent' => 'WhatsApp 알림 전송됨',
  ],

  'info' => [
    'upcoming' => '예정됨',
    'ongoing' => '진행 중',
    'past' => '지난',
    'full' => '만석',
    'available_slots' => ':count개 자리 가능',
    'unlimited_slots' => '무제한 자리',
  ],

  'created_successfully' => '이벤트가 생성되었습니다.',
  'updated_successfully' => '이벤트가 업데이트되었습니다.',
  'deleted_successfully' => '이벤트가 삭제되었습니다.',
  'delete_title' => '이벤트 삭제',
  'rsvp_updated_successfully' => 'RSVP 상태가 업데이트되었습니다.',
  'reminders_sent_successfully' => ':count명의 참석자에게 알림이 전송되었습니다.',
  'documentation_uploaded_successfully' => '문서가 업로드되었습니다.',
  'documentation_deleted_successfully' => '문서가 삭제되었습니다.',
];
