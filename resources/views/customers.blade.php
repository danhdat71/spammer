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
               <form class="col-8">
                  <div class="row">
                     <div class="col-lg-5">
                        <input placeholder="Nguyễn Văn A hoặc HCM hoặc 0123" type="text" class="form-control">
                     </div>
                     <div class="col-lg-3">
                        <select name="" id="" class="form-control">
                           <option value="">Sắp xếp</option>
                           <option value="">Mới nhất</option>
                           <option value="">Cũ nhất</option>
                        </select>
                     </div>
                     <div class="col-lg-3">
                        <select name="" id="" class="form-control">
                           <option value="">Trạng thái</option>
                           <option value="">Nợ xấu</option>
                           <option value="">Tốt</option>
                        </select>
                     </div>
                     <div class="col-lg-1"><button class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i></button></div>
                  </div>
               </form>
               <div class="col-4">
                  <button class="btn btn-success mr-1">Nhúng Excel <i class="fa-solid fa-upload"></i></button>
                  <button class="btn btn-warning text-light">Spam SMS <i class="fa-solid fa-envelope"></i></button>
               </div>
            </div>
            <div class="row pt-3">
               <div class="col-12">
                  <table class="table table-middle">
                     <thead class="bg-info">
                        <tr>
                           <th>Tên KH</th>
                           <th>SĐT</th>
                           <th>CCCD</th>
                           <th>Địa chỉ</th>
                           <th>Nợ xấu</th>
                           <th>Thao tác</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>Lê Thị Thúy Bình</td>
                           <td>0352026756</td>
                           <td>371945497</td>
                           <td>Thị Trấn Thứ Ba, An Biên, Kiên Giang</td>
                           <td>
                              <select name="" id="" class="form-control">
                                 <option value="1">Tốt</option>
                                 <option value="0">Nợ xấu</option>
                              </select>
                           </td>
                           <td>
                              <a href="" target="_blank" class="btn btn-sm bg-info">Mở Zalo</a>
                              <button class="btn btn-sm bg-warning">Spam SMS</button>
                              <button class="btn btn-info btn-sm"><i class="fa-solid fa-circle-info"></i></button>
                              <button class="btn btn-sm btn-warning text-light"><i class="fa-solid fa-pen"></i></button>
                              <a onclick="return confirm('Bạn có chắc muốn xóa ?')" href="" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
        </div>
    </section>
</div>
@endsection