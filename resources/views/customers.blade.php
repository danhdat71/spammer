@extends('main')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
       <div class="container-fluid">
          <div class="row mb-2">
             <div class="col-sm-6">
                <h1 class="m-0">Khách hàng</h1>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="#">Home</a></li>
                   <li class="breadcrumb-item active">Khách hàng</li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
               <form action="customers" class="col-8" method="get">
                  <div class="row">
                     <div class="col-lg-5">
                        <input
                           name="keyword"
                           placeholder="Nguyễn Văn A hoặc HCM hoặc 0123"
                           type="text"
                           class="form-control"
                           value="{{$filter['keyword']}}"
                        >
                     </div>
                     <div class="col-lg-2">
                        <select name="is_bad" class="form-control">
                           <option value="">Trạng thái</option>
                           <option @if($filter['is_bad'] == '1') {{'selected'}} @endif value="1">Nợ xấu</option>
                           <option @if($filter['is_bad'] == '0') {{'selected'}} @endif value="0">Tốt</option>
                        </select>
                     </div>
                     <div class="col-lg-2">
                        <select name="is_zalo_spamed" class="form-control">
                           <option value="">Zalo spam</option>
                           <option @if($filter['is_zalo_spamed'] == '0') {{'selected'}} @endif value="0">Chưa spam</option>
                           <option @if($filter['is_zalo_spamed'] == '1') {{'selected'}} @endif value="1">Đã spam</option>
                        </select>
                     </div>
                     <div class="col-lg-2">
                        <select name="order_by" class="form-control">
                           <option value="">Sắp xếp</option>
                           <option @if($filter['order_by'] == 'id|desc') {{'selected'}} @endif value="id|desc">Mới nhất</option>
                           <option @if($filter['order_by'] == 'id|asc') {{'selected'}} @endif value="id|asc">Cũ nhất</option>
                        </select>
                     </div>
                     <div class="col-lg-1"><button class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i></button></div>
                  </div>
               </form>
               <div class="col-4">
                  <button
                     data-bs-target="#import-excel"
                     data-bs-toggle="modal"
                     class="btn btn-success mr-1"
                  >Nhúng Excel <i class="fa-solid fa-upload"></i></button>
                  <button
                     class="btn btn-warning text-light"
                     @if (count($customers) == 0)
                        {{'disabled'}}
                     @endif
                  >Spam SMS <i class="fa-solid fa-envelope"></i></button>
                  <form class="d-inline" method="post" action="customers">
                     {{ csrf_field() }}
                     {{ method_field('DELETE') }}
                     <button
                        @if (count($customers) == 0)
                        {{'disabled'}}
                        @endif
                        onclick="return confirm('Bạn có chắc muốn xóa sạch toàn bộ dữ liệu KH ?')"
                        class="btn btn-danger">Dọn sạch
                     </button>
                  </form>
               </div>
            </div>
            <div class="row pt-3">
               <div class="col-12">
                  <table class="table table-middle">
                     <thead class="bg-info">
                        <tr>
                           <th>Tên KH</th>
                           <th>CCCD</th>
                           <th>SĐT</th>
                           <th>Địa chỉ</th>
                           <th>Nợ xấu</th>
                           <th>Thao tác</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($customers as $customer)
                        <tr
                           class="
                              @if ($customer->is_bad)
                              {{'opacity-0_7'}}
                              @endif
                           "
                        >
                           <td>{{$customer->name}}</td>
                           <td>{{$customer->cccd}}</td>
                           <td>{{$customer->phone}}</td>
                           <td>{{$customer->address}}</td>
                           <td>
                              <select
                                 data-id="{{$customer->id}}"
                                 class="form-control set-status-is-bad"
                              >
                                 <option value="0">Tốt</option>
                                 <option
                                    @if($customer->is_bad == '1')
                                    {{'selected'}}
                                    @endif
                                    value="1">Nợ xấu</option>
                              </select>
                           </td>
                           <td>
                              <button
                                 data-zalo-url="{{env('ZALO_URL')}}/{{$customer->phone}}"
                                 data-id="{{$customer->id}}"
                                 class="btn btn-sm bg-info open-customer-zalo"
                              >
                                 @if($customer->is_zalo_spamed == '0')
                                 {{'Mở Zalo'}}
                                 @else
                                 {{'Đã spam zalo'}}
                                 @endif
                              </button>
                              <button class="btn btn-sm bg-warning">Spam SMS</button>
                              <button
                                 data-id="{{$customer->id}}"
                                 class="btn btn-sm btn-warning text-light edit-customer"
                                 data-bs-target="#customer-note"
                                 data-bs-toggle="modal"
                              ><i class="fa-solid fa-pen"></i></button>
                              <form class="d-inline" method="post" action="customers/{{$customer->id}}">
                                 {{ csrf_field() }}
                                 {{ method_field('DELETE') }}
                                 <button
                                    onclick="return confirm('Bạn có chắc muốn xóa ?')"
                                    class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i>
                                 </button>
                              </form>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {{$customers->appends($filter)->links()}}
               </div>
            </div>
        </div>
    </section>

    <div class="modals">
      <!-- Import excel -->
      <div
         class="modal fade"
         id="import-excel"
         tabindex="-1"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true"
      >
         <div class="modal-dialog">
         <form id="form-excel" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Chọn file excel</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <input name="excel" id="file-excel-input" type="file" class="form-control" accept=".xlsx, .xls">
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
               <button id="import-excel-btn" type="button" class="btn btn-success">Chèn vào ứng dụng</button>
            </div>
         </form>
         </div>
      </div>
      <!-- Customer note -->
      <div
         class="modal fade"
         id="customer-note"
         tabindex="-1"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true"
      >
         <div class="modal-dialog" style="max-width:800px;">
         <form id="form-customer-info" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">
                  Ghi chú thông tin khách hàng: 
                  <span>Danh Đạt</span>
               </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="form-group col-6">
                     <label>Họ tên</label>
                     <input id="name" name="name" type="text" class="form-control">
                  </div>
                  <div class="form-group col-6">
                     <label>Số điện thoại</label>
                     <input id="phone" name="phone" type="text" class="form-control">
                  </div>
               </div>
               <div class="row">
                  <div class="form-group col-6">
                     <label>CCCD</label>
                     <input id="cccd" name="cccd" type="text" class="form-control">
                  </div>
                  <div class="form-group col-6">
                     <label>Địa chỉ</label>
                     <input id="address" name="address" type="text" class="form-control">
                  </div>
               </div>
               <div class="row">
                  <div class="form-group col-12">
                     <label for="">Ghi chú</label>
                     <textarea id="note" class="form-control" name="note" rows="10"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng lại</button>
               <button id="update-customer-btn" type="button" class="btn btn-success">Cập nhật</button>
            </div>
         </form>
         </div>
      </div>
    </div>
</div>
@endsection