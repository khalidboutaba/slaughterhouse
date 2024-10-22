<!-- Partial modal for delete confirmation -->
<div class="modal fade" id="deleteModal-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalCenterTitle">تأكيد الحذف</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من أنك تريد حذف هذا السجل؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">إغلاق</span>
                </button>
                <!-- Button to submit the form -->
                <button type="button" class="btn btn-primary ms-1" onclick="document.getElementById('delete-form-{{ $id }}').submit();">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">حذف</span>
                </button>
            </div>
        </div>
    </div>
</div>
