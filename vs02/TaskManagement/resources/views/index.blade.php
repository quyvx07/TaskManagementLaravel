@extends('home')
@section('content')
    <div class="col-12">
        <h1>Danh Sách Khách Hàng</h1>
    </div>
    <a class="btn btn-outline-primary" href="{{route('customers.filterByCity')}}" data-toggle="modal"
       data-target="#cityModal">
        Lọc
    </a>
    <div class="col-12">
        @if (Session::has('success'))
            <p class="text-success">
                <i class="fa fa-check" aria-hidden="true"></i>
                {{ Session::get('success') }}
            </p>
        @endif

        @if(isset($totalCustomerFilter))
            <span class="text-muted">
                    {{'Tìm thấy' . ' ' . $totalCustomerFilter . ' '. 'khách hàng:'}}
                </span>
        @endif

        @if(isset($cityFilter))
            <div class="pl-5">
                   <span class="text-muted"><i class="fa fa-check" aria-hidden="true"></i>
                       {{ 'Thuộc tỉnh' . ' ' . $cityFilter->name }}</span>
            </div>
        @endif
    </div>
    <table class="table table-striped text-center">
        <thead>
        <tr>
            <th>ID</th>
            <th>Họ và tên</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Birth Day</th>
            <th>City</th>
            <th>Image</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        @forelse($customers as $customer)
            <tr>
                <th class="align-middle">{{ $customer->id }}</th>
                <th class="align-middle"><a
                        href="{{route('customers.show',["id"=>$customer->id])}}">{{ $customer->name }}</a></th>
                <th class="align-middle">{{ $customer->phone }}</th>
                <th class="align-middle">{{ $customer->email }}</th>
                <th class="align-middle">{{ $customer->date_of_birth }}</th>
                <th class="align-middle">{{ $customer->city->name }}</th>
                <th class="align-middle"><img src="{{ asset('storage/' . $customer->image) }}" alt=""
                                              style="width: 50px"></th>
                <th class="align-middle"><a href="{{route('customers.edit',["id"=>$customer->id])}}">
                        <button class="btn btn-primary">Edit</button>
                    </a>
                    <a href="{{route('customers.destroy',["id"=>$customer->id])}}">
                        <button onclick="return confirm('Bạn muốn xóa không?') " class="btn btn-primary">Delete
                        </button>
                    </a>
                </th>
            </tr>
        @empty
            <tr>
                <td colspan="5"><h5 class="text-primary">Hiện tại chưa có danh sách khách hàng nào!</h5></td>
            </tr>
        @endforelse
    </table>
    <div class="row">{{ $customers->appends(request()->query()) }}</div>
    <!-- Modal -->
    <div class="modal fade" id="cityModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <form action="{{ route('customers.filterByCity') }}" method="get">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!--Lọc theo khóa học -->
                        <div class="select-by-program">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label border-right">Lọc khách hàng theo tỉnh
                                    thành</label>
                                <div class="col-sm-7">
                                    <select class="custom-select w-100" name="city_id">
                                        <option value="">Chọn tỉnh thành</option>
                                        @foreach($cities as $city)
                                            @if(isset($cityFilter))
                                                @if($city->id == $cityFilter->id)
                                                    <option value="{{$city->id}}"
                                                            selected>{{ $city->name }}</option>
                                                @else
                                                    <option value="{{$city->id}}">{{ $city->name }}</option>
                                                @endif
                                            @else
                                                <option value="{{$city->id}}">{{ $city->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- </form> -->
                        </div>
                        <!--End-->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitAjax" class="btn btn-primary">Chọn</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
