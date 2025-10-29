<form action="" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function() {
                let title = $(this).data('title');
                let item = $(this).data('item');
                let url = $(this).data('url');

                Swal.fire({
                    title: title,
                    text: `{{ __('common.delete_confirmation_text') }} "${item}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('common.delete_confirm_button') }}',
                    cancelButtonText: '{{ __('common.delete_cancel_button') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-delete').attr('action', url);
                        $('#form-delete').submit();
                    }
                });
            });
        });
    </script>
@endpush
