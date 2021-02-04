<div>
    <div class="d-flex flex-row p-2 justify-content-between" style="background-color: rgba(255, 255, 255, 0.5)">
        @if(!\Illuminate\Support\Facades\Auth::check())
            <a href="{{route('login')}}" class="btn btn-primary">ورود</a>
        @else
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button class="btn btn-primary">خروج</button>
            </form>
        @endif
        <p class="text-white font-weight-bold h3 m-0">وظیفه شناس</p>
    </div>
    <div class="container d-flex flex-row py-5">
        <form class="col-3 px-2" wire:submit.prevent="taskStore(Object.fromEntries(new FormData($event.target)))">
            <div class="w-100 bg-white rounded">
                <div class="modal-body">
                    <div class="d-flex flex-column">
                        <label for="">
                            عنوان:
                            <input type="text" class="form-control" name="title">
                        </label>
                        <label for="">
                            تخصیص:
                            <select id="" class="form-control" name="member">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label for="">
                            مهلت انجام:
                            <input type="date" class="form-control" name="dueTime">
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    <button type="submit" class="btn btn-primary" data-dismiss="modal">افزودن</button>
                </div>
            </div>
        </form>
        <div class="col-3 px-2">
            <div class="w-100 bg-white rounded">
                <div class="bg-primary w-100 rounded">
                    <h5 class="text-center text-white py-2">انجام شدن</h5>
                </div>
                <div class="p-2">
                    @foreach($todoList as $item)
                        <div class="card p-2" wire:key="{{ $item->id }}">
                            <div>
                                <p>{{$item->title}}</p>
                                @foreach($item->users as $user)
                                    <span class="badge badge-primary px-2">{{$user->name}}</span>
                                @endforeach
                            </div>
                            <div>
                                {{$item->dueTime}}
                            </div>
                            <form wire:key="{{ $item->id }}" class="d-flex flex-row my-3"
                                  wire:submit.prevent="statusUpdate(Object.fromEntries(new FormData($event.target)))">
                                <input type="text" name="id" value="{{$item->id}}" hidden>
                                <select name="status" class="form-control ml-3">
                                    <option value="todo">انجام دادن</option>
                                    <option value="doing">درحال انجام</option>
                                    <option value="done">انجام شده</option>
                                </select>
                                <button type="submit" class="btn btn-primary">بروزرسانی</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-3 px-2">
            <div class="w-100 bg-white rounded">
                <div class="bg-primary w-100 rounded">
                    <h5 class="text-center text-white py-2">درحال انجام</h5>
                </div>
                <div class="p-2">
                    @foreach($doingList as $item)
                        <div class="card p-2" wire:key="{{ $item->id }}">
                            <div>
                                <div>
                                    <p>{{$item->title}}</p>
                                    @foreach($item->users as $user)
                                        <span class="badge badge-primary px-2">{{$user->name}}</span>
                                    @endforeach
                                </div>
                                <div>
                                    {{$item->dueTime}}
                                </div>
                            </div>
                            <form class="d-flex flex-row my-3"
                                  wire:submit.prevent="statusUpdate(Object.fromEntries(new FormData($event.target)))">
                                <input type="text" name="id" value="{{$item->id}}" hidden>
                                <select name="status" class="form-control ml-3">
                                    <option value="todo">انجام دادن</option>
                                    <option value="doing" selected>درحال انجام</option>
                                    <option value="done">انجام شده</option>
                                </select>
                                <button type="submit" class="btn btn-primary">بروزرسانی</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-3 px-2">
            <div class="w-100 bg-white rounded">
                <div class="bg-primary w-100 rounded">
                    <h5 class="text-center text-white py-2">انجام شده</h5>
                </div>
                <div class="p-2">
                    @foreach($doneList as $item)
                        <div class="card p-2" wire:key="{{ $item->id }}">
                            <div>
                                <div>
                                    <p>{{$item->title}}</p>
                                    @foreach($item->users as $user)
                                        <span class="badge badge-primary px-2">{{$user->name}}</span>
                                    @endforeach
                                </div>
                                <div >
                                    {{$item->dueTime}}
                                </div>
                            </div>
                            <form class="d-flex flex-row my-3"
                                  wire:submit.prevent="statusUpdate(Object.fromEntries(new FormData($event.target)))">
                                <input type="text" name="id" value="{{$item->id}}" hidden>
                                <select name="status" class="form-control ml-3">
                                    <option value="todo">انجام دادن</option>
                                    <option value="doing">درحال انجام</option>
                                    <option value="done" selected>انجام شده</option>
                                </select>
                                <button type="submit" class="btn btn-primary">بروزرسانی</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">افزودن وظیفه</h5>
                    <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
