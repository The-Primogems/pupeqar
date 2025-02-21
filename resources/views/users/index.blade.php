<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if ($message = Session::get('edit_user_success'))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                        @endif
                        {{-- <div class="mb-3 ml-1">
                            <div class="d-inline mr-2">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-2"><i class="bi bi-plus"></i> Add New User</a>
                            </div>
                        </div>  
                        <hr> --}}
                        <div class="table-responsive">
                            <table class="table" id="user_table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Roles</th>
                                        <th>Date Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="tr-hover" role="button">
                                            <td onclick="window.location.href = '{{ route('admin.users.show', $user->id) }}' " >{{ $loop->iteration }}</td>
                                            <td onclick="window.location.href = '{{ route('admin.users.show', $user->id) }}' " >{{ $user->first_name." ".$user->middle_name." ".$user->last_name." ".$user->suffix }}</td>
                                            <td onclick="window.location.href = '{{ route('admin.users.show', $user->id) }}' ">
                                                @forelse ($rolesperuser[$user->id] as $user_role)
                                                    @if ($loop->last)
                                                        {{ $user_role->name }}
                                                    @else
                                                        {{ $user_role->name }},
                                                    @endif
                                                @empty
                                                    -
                                                @endforelse
                                            </td>
                                            <td onclick="window.location.href = '{{ route('admin.users.show', $user->id) }}' " >{{ $user->created_at }}</td>
                                            <td>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="btn-group" role="group">
                                                        
                                                        <a href="{{ route('admin.users.edit', $user->id) }}"  class="action-edit mr-3"><i class="bi bi-pencil-square"></i> Edit</a>
                                                        <i class="bi bi-trash trash"></i> <input type="submit" class="action-delete" value="Delete">
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
     @push('scripts')
     <script type="text/javascript" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
     <script type="text/javascript" src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>
     <script>
         $(document).ready( function () {
             $('#user_table').DataTable({
             });
         } );
     </script>
     
     @endpush
</x-app-layout>