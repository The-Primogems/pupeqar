<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('View Technical Extension Program/Project/Activity') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                @if ($message = Session::get('cannot_access'))
                <div class="alert alert-danger alert-index">
                    {{ $message }}
                </div>
                @endif
                <div class="d-flex mr-2">
                    <p class="mr-auto">
                        <a class="back_link" href="{{ route('technical-extension.index') }}"><i class="bi bi-chevron-double-left"></i>Back to all Technical Extension Programs, Projects, and Activities</a>
                    </p>
                    <p>
                        <a href="{{ route('technical-extension.edit', $technical_extension->id) }}" class="action_buttons_show mr-3"><i class="bi bi-pencil-square"></i> Edit</a>
                    </p>
                    <p>
                        <button type="button" value="{{ $technical_extension->id }}" data-bs-extension="{{ $technical_extension->name_of_adoptor }}" class="action-delete action_buttons_show" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i> Delete</button>
                    </p>
                </div>
                @include('show', ['formFields' => $extensionFields, 'value' => $values])

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <h5 id="textHome" style="color:maroon">Supporting Documents</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 style="color:maroon"><i class="far fa-file-alt mr-2"></i>Documents</h6>
                                        <div class="row">
                                            @if (count($documents) > 0)
                                                @foreach ($documents as $document)
                                                    @if(preg_match_all('/application\/\w+/', \Storage::mimeType('documents/'.$document['filename'])))
                                                        <div class="col-md-12 mb-3" id="doc-{{ $document['id'] }}">
                                                            <div class="card bg-light border border-maroon rounded-lg">
                                                                <div class="card-body">
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-12">
                                                                            <div class="embed-responsive embed-responsive-1by1">
                                                                                <iframe  src="{{ route('document.view', $document['filename']) }}" width="100%" height="500px"></iframe>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="col-md-4 offset-md-4">
                                                    <h6 class="text-center">No Documents Attached</h6>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 style="color:maroon"><i class="far fa-image mr-2"></i>Images</h6>
                                        <div class="row">
                                            @if(count($documents) > 0)
                                                @foreach ($documents as $document)
                                                    @if(preg_match_all('/image\/\w+/', \Storage::mimeType('documents/'.$document['filename'])))
                                                        <div class="col-md-6 mb-3" id="doc-{{ $document['id'] }}">
                                                            <div class="card bg-light border border-maroon rounded-lg">
                                                                <a href="{{ route('document.display', $document['filename']) }}" data-lightbox="gallery" data-title="{{ $document['filename'] }}" target="_blank">
                                                                    <img src="{{ route('document.display', $document['filename']) }}" class="card-img-top img-resize"/>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="col-md-4 offset-md-4">
                                                    <h6 class="text-center">No Documents Attached</h6>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    @include('delete')

    @push('scripts')
    <script>
         //Item to delete to display in delete modal
         var deleteModal = document.getElementById('deleteModal')
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var id = button.getAttribute('value')
            var rtmmiTitle = '{{ ($values['program_title'] != null ? $values['program_title'] : ($values['project_title'] != null ? $values['project_title'] : ($values['activity_title'] != null ? $values['activity_title'] : ''))) }}'
            var itemToDelete = deleteModal.querySelector('#itemToDelete')
            itemToDelete.textContent = rtmmiTitle

            var url = '{{ route("technical-extension.destroy", ":id") }}';
            url = url.replace(':id', id);
            document.getElementById('delete_item').action = url;
        });
    </script>
    @endpush
</x-app-layout>