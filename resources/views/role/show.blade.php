
<div class="modal fade" wire:ignore.self id="viewModal{{ $role->id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-center"> &ThinSpace;&ThinSpace;{{ $role->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless ">
                    <tbody>
                        <tr>
                            <th colspan="2">Permission :</th>
                            
                            @if (count($role->permissions->pluck('name')) == 0)
                                <td style="color:#c0c0c0;">No permission</td>
                            @endif
                        </tr>
                        @foreach ($role->permissions->pluck('name') as $nameP) 
                                    <tr>
                                        <th></th>
                                        <td style="color:#acacac;">{{__("role.".$nameP)}}</td>
                                    </tr>
                        @endforeach
                    </tbody>
                </table>
                <div
                    class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                <a href="{{ route('role.edit', $role->id) }}" class="btn btn-edit">
                    <i class="bi bi-pencil-square"></i> Modifier
                </a>
                    <button type="button" class="btn btn-secondary order-last order-md-first"
                        data-bs-dismiss="modal"><i class="bi bi-caret-left-fill"></i>
                        Fermer</button>
                        
                </div>

            </div>
        </div>
    </div>
</div>
