<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$meta_title}} </title>

    <!-- Google Font -->
   <!-- <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet"-->
    <!---------Seo--------->
    <meta name="description" content="{{$meta_desc}}">
    <meta name="keywords" content="{{$meta_keywords}}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link  rel="canonical" href="{{$url_canonical}}" />
    <meta name="author" content="">
    <link  rel="icon" type="image/x-icon" href="" />
    <!---------Seo--------->
    <!---------Share fb--------->
    <meta property="og:url"           content="{{$url_canonical}}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{{$meta_title}}" />
    <meta property="og:description"   content="{{$meta_desc}}" />
    {{-- <meta property="og:image"         content="" /> --}}
    <!---------End share fb--------->

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/sweetalert.css')}}" type="text/css">
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    
</head>

<body>
    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i>FreshFruit@gmail.com</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                                <a href="https://twitter.com/"><i class="fa fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a>
                                <a href="https://www.pinterest.com/"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                            <div class="header__top__right__language">
                                <image src="{{URL::to('frontend/image/language1.png')}}" with="20px" height="20px" alt="">
                                <div>{{__('Ngôn Ngữ')}}</div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="{{URL::to('language',['en'])}}">English</a></li>
                                    <li><a href="{{URL::to('language',['vi'])}}">Vietnamese</a></li>
                                </ul>
                            </div>
                            <div class="header__top__right__language">
                                {{-- kiểm tra id khách hàng nếu chưa bắt đăng nhập --}}
                                <?php
                                    $customer_id = Session::get('customer_id');
                                    if ($customer_id != NULL) {

                                        ?>
                                        <i class="fa fa-user"></i> <div>{{__('Thông tin')}}</div>
                                        <span class="arrow_carrot-down"></span>
                                        <ul>
                                            <li><a href="{{URL::to('/history-order')}}">{{__('Lịch Sử')}}</a></li></a></li>
                                            <li><a href="{{URL::to('/logout-checkout')}}">{{__('Đăng Xuất')}}</a></li>
                                        </ul>
                                        <?php
                                    }else{
                                        ?>

                                        <i class="fa fa-user"></i><a href="{{URL::to('/login-checkout')}}"><div style="margin-left: 5px;">{{__('Đăng Nhập')}}</div></a>
                                        <?php 

                                    }
                                    ?>
                                    <i class="fa fa-user-plus"></i><a href="{{URL::to('/register-checkout')}}"><div style="margin-left: 5px;"></div>Đăng ký</div></a>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="{{-- header__logo --}}">
                       <center> <a href="{{URL::to('/trang-chu')}}"><image style="display: block;max-width:200px;max-height:150px;width: auto;height: auto;" src="{{URL::to('frontend/image/logo.png')}}" alt=""></a></center>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="{{URL::to('/trang-chu')}}">{{__('Trang Chủ')}}</a></li>
                            <li><a href="{{URL::to('/tin-tuc')}}">{{__('Tin Tức')}}</a>
                            </li>

                            <?php
                            $customer_id = Session::get('customer_id');
                            if ($customer_id != NULL) {

                                ?>
                                <li><a href="{{URL::to('/gio-hang')}}">{{__('Giỏ Hàng')}}</a></li>
                                <?php
                            }else{
                                ?>

                                <li><a href="{{URL::to('/login-checkout')}}">{{__('Giỏ Hàng')}}</a></li>
                                <?php 
                            }      
                            ?>

                            <?php
                            $customer_id = Session::get('customer_id');
                            $shipping_id = Session::get('shipping_id');
                            if ($customer_id != NULL && $shipping_id ==NULL ) {

                                ?>
                                <li><a href="{{URL::to('/checkout')}}">{{__('Thanh Toán')}}</a></li>
                                <?php
                            }elseif($customer_id != NULL && $shipping_id !=NULL ){
                                ?>
                                <li><a href="{{URL::to('/payment')}}">{{__('Thanh Toán')}}</a></li>
                                <?php 
                            }else{      
                                ?>
                                <li><a href="{{URL::to('/login-checkout')}}">{{__('Thanh Toán')}}</a></li>
                                <?php
                            }
                            ?>

                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            {{-- kiểm tra id khách hàng nếu chưa bắt đăng nhập --}}
                             {{-- <?php
                                    $customer_id = Session::get('customer_id');
                                    if ($customer_id != NULL) {

                                        ?> --}}
                                        <li><a onclick="scanqr();"  data-toggle="modal" data-target="#dialog1"><i class="fa fa-qrcode"></i></a></li>
                                        <li id="show-cart"></li>
                                     {{--    <li><a href="{{URL::to('/gio-hang')}}"><i class="fa fa-shopping-bag"></i> <span>1</span></a></li> --}}
                                        {{-- <?php
                                    }else{
                                        ?>

                                        <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-shopping-bag"></i> <span>1</span></a></li>
                                        <?php 
                                    }      
                                        ?> --}}

                        </ul>
                        <div class="header__cart__price" id="total-home"></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
        <div class="modal fade" id="dialog1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                    <div class="modal-header">
                        <h5 style="text-align: center;" class="modal-title">{{__('Quét Mã Qr Của Bạn')}}</h5>
                        <button type="button" onclick="close();" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <video style="" id="preview" width="100%"></video>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Header Section End -->
    
    <!-- Hero Section Begin -->
    
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    
    <!-- Categories Section End -->
    <!-- Featured Section Begin -->

    @yield('content')
  <!-- Banner Begin -->
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
   
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    
    <!-- Blog Section End -->
    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                @foreach($contact_info as $key => $ci)
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <br>
                    <div class="footer__about">
                        <center><h5>{{__('Địa Chỉ')}}</h5></center>
                        <div class="footer__about__logo">
                            <a href="{{URL::to('/trang-chu')}}"><image width="300" height="150" src="{{URL::to('upload/contact/'.$ci->info_logo)}}" alt=""></a>
                        </div>
                        <ul>
                            <li>{!!$ci->info_contact!!}</li>
                        </ul>
                    </div>
                    <div class="footer__about">
                        <center><h5>{{__('Bài Viết Hữu Ích')}}</h5></center>
                        <ul>
                            @foreach($post_huuich as $key => $huuich)
                            <li><a href="{{URL::to('/bai-viet/'.$huuich->post_slug)}}">{{$huuich->post_title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
               
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <br>
                     <div class="footer__about">
                        <center><h5>{{__('Map')}}</h5></center>
                        <center>{!!$ci->info_map!!}</center>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="{{asset('frontend/js/jquery.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    
    <script src="{{asset('frontend/js/jquery.slicknav.js')}}"></script>
    <script src="{{asset('frontend/js/mixitup.min.js')}}"></script>
    <script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
{{--     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    <script src="{{asset('frontend/js/main.js')}}"></script>
    <script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>

    {{-- script share fb --}}
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0" nonce="he8bFVjf"></script>
    {{-- end script --}}
    {{-- add số lượng --}}
    <script>//<![CDATA[
        $('input.input-qty').each(function() {
          var $this = $(this),
            qty = $this.parent().find('.is-form'),
            min = Number($this.attr('min')),
            max = Number($this.attr('max'))
          if (min == 0) {
            var d = 0
          } else d = min
          $(qty).on('click', function() {
            if ($(this).hasClass('minus')) {
              if (d > min) d += -1
            } else if ($(this).hasClass('plus')) {
              var x = Number($this.val()) + 1
              if (x <= max) d += 1
            }
            $this.attr('value', d).val(d)
          })
        })
    </script>
    {{-- end add số lượng --}}
    <script>
        $('#dialog1').modal('show')
        function scanqr(){
             let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
              scanner.addListener('scan', function (content) {
                window.location.href=content;
              });
              Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                  scanner.start(cameras[0]);
                } else {
                  console.error('No cameras found.');
                }
              }).catch(function (e) {
                console.error(e);
              });
          }
    </script>
    {{-- qr scan --}}
    {{-- end qr scan --}}
    {{-- sản phẩm yêu thích javascript --}}
    <script type="text/javascript">
        function del_wishList(id){
          if (localStorage.getItem('data')!=null) {
            var data = JSON.parse(localStorage.getItem('data'));
            var index = data.findIndex(item => item.id == id);
            // alert(index);
            data.splice(index, 1);
            localStorage.setItem('data', JSON.stringify(data));

            document.getElementById("delete"+id).remove(); 
        
          }
        }

         function view(){
            

             if(localStorage.getItem('data')!=null){

                 var data = JSON.parse(localStorage.getItem('data'));

                 data.reverse();// đảo ngược sản phẩm mới lên đầu

                 document.getElementById('row_wishlist').style.overflow = 'scroll';
                 document.getElementById('row_wishlist').style.height = '200px';
                
                 for(i=0;i<data.length;i++){

                    var name = data[i].name;
                    var price = data[i].price;
                    var image = data[i].image;
                    var url = data[i].url;
                    var id = data[i].id;

                    $('#row_wishlist').append('<div class="row" id="delete'+id+'" style="margin:10px 0"><div class="col-md-4"><img width="100%" src="'+image+'"></div><div class="col-md-8 info_wishlist"><p>'+name+'</p><p style="color:#FE980F">'+price+'</p><a class="abc" href="'+url+'">Đặt hàng</a><a class="abc" style="margin-left:5px" onclick="del_wishList('+id+')">Xóa</a></div>');
                }

            }

        }

        view();
       

       function add_wistlist(clicked_id){
           
            var id = clicked_id;
            var name = document.getElementById('wishlist_productname'+id).value;
            var price = document.getElementById('wishlist_productprice'+id).value;
            var image = document.getElementById('wishlist_productimage'+id).src;
            var url = document.getElementById('wishlist_producturl'+id).href;
            var newItem = {
                'url':url,
                'id' :id,
                'name': name,
                'price': price,
                'image': image
            }
            //kiem tra neu chua co thi set la rong
            if(localStorage.getItem('data')==null){
               localStorage.setItem('data', '[]');
            }
            //neu co roi thi lay lai
            var old_data = JSON.parse(localStorage.getItem('data'));

            var matches = $.grep(old_data, function(obj){
                return obj.id == id;
            })

            if(matches.length){
                alert('{{__('Sản phẩm bạn đã yêu thích,nên không thể thêm')}}');

            }else{

                old_data.push(newItem);

               $('#row_wishlist').append('<div class="row" id="delete'+id+'" style="margin:10px 0;"><div class="col-md-4"><img width="100%" src="'+newItem.image+'"></div><div class="col-md-8 info_wishlist"><p>'+newItem.name+'</p><p style="color:#FE980F">'+newItem.price+'</p><a class="abc" href="'+newItem.url+'">Đặt hàng</a><a class="abc" style="margin-left:5px" onclick="del_wishList('+id+')">Xóa</a></div>');

            }
           
            localStorage.setItem('data', JSON.stringify(old_data));

           
       }
    </script>
    {{-- end sản phẩm yêu thích --}}
    {{-- script sweetalert --}}
    <script type="text/javascript">
        show_cart();//đếm giỏ hàng
        total_home();
            function show_cart(){
                $.ajax({
                    url:'{{url('/show-cart')}}',
                    method: "GET",
                    success:function(data){
                        $('#show-cart').html(data);
                    }

                });
            }
            //total home
            function total_home(){
                $.ajax({
                    url:'{{url('/total-home')}}',
                    method: "GET",
                    success:function(data){
                        $('#total-home').html(data);
                    }

                });
            }
        $(document).ready(function(){
            $('.add-to-cart').click(function(){
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var _token = $('input[name="_token"]').val();

                if (parseInt(cart_product_qty)>parseInt(cart_product_quantity)){
                    if (parseInt(cart_product_quantity)==0) {
                        swal("{{__('Vui lòng liên hệ SĐT: 0379145253 để đặt hàng!')}}");
                    } else{
                        swal("{{__('Vui Lòng Nhập Số Lượng Nhỏ Hơn')}} "+cart_product_quantity,"", "warning");
                    }
                }else{
                    $.ajax({
                    url: '{{url('/add-cart-ajax')}}',
                    method: 'POST',
                    data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,cart_product_price:cart_product_price,cart_product_qty:cart_product_qty,_token:_token,cart_product_quantity:cart_product_quantity},
                    success:function(){
                        swal({
                                title: "{{__('Sản Phẩm Của Bạn Đã Thêm Vào Giỏ Hàng')}}",
                                text: "{{__('Tiếp Tục Mua Hàng Hoặc Thanh Toán')}}",
                                showCancelButton: true,
                                cancelButtonText: "{{__('Mua Tiếp')}}",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "{{__('Giỏ Hàng')}}",
                                closeOnConfirm: false
                            },
                            function() {
                                window.location.href = "{{url('/gio-hang')}}";
                            });
                            show_cart();
                            total_home();

                    }

                });
                }
            });
        });
    </script>
    {{-- phí vận chuyển --}}
    <script type="text/javascript">

    $(document).ready(function(){
        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if(action=='city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url : '{{url('/select-city-home')}}',
                method: 'POST',
                data:{action:action,ma_id:ma_id,_token:_token},
                success:function(data){
                   $('#'+result).html(data);     
                }
            });
        }); 
    });
  </script>
  <script type="text/javascript">
        $(document).ready(function(){
            $('.calculate').click(function(){
                // var matp = $('.city').val();
                // var maqh = $('.province').val();
                // var xaid = $('.wards').val();
                // var _token = $('input[name="_token"]').val();
                // if(matp == '' || maqh =='' || xaid ==''){
                //     swal("{{__('Lỗi!')}}", "{{__('Vui lòng chọn thông tin để tính phí vận chuyển !')}}", "info");
                // }else{
                //     $.ajax({
                //     url : '{{url('/calculate-ship')}}',
                //     method: 'POST',
                //     data:{matp:matp,maqh:maqh,xaid:xaid,_token:_token},
                //     success:function(){
                //        location.reload(); 
                //     }
                //     });
                // } 
                
        });
    });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
           $('.null-fee').click(function(){
                    swal("{{__('Lỗi!')}}", "{{__('Vui lòng chọn phí vận chuyển ở trên !')}}", "warning");     
        });
             });
        </script>
         <script type="text/javascript">
        $(document).ready(function(){
           $('.null-customer').click(function(){
                    swal("{{__('Bạn Chưa Đăng Nhập !')}}", "{{__('Đăng Nhập Để Tiếp Tục!')}}", "info");           
        });
             });
        </script>
         <script type="text/javascript">
        $(document).ready(function(){
           $('.null-cart').click(function(){
                    swal("{{__('Giỏ Hàng Trống !')}}", "{{__('Vui Lòng Thêm Sản Phẩm Để Tiếp Tục!')}}", "info");           
        });
             });
        </script>
    {{-- end phí vận chuyển --}}
    {{-- send-order --}}
    <script type="text/javascript">
        $(document).ready(function(){
            $('.send-order').click(function(){
                swal({
                  title: "{{__('Đơn hàng của bạn')}}",
                  text: "{{__('Đơn hàng sẽ không được hoàn trả sau khi đặt, bạn có muốn tiếp tục ?')}}",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "{{__('Tiếp tục!')}}",
                  cancelButtonText: "{{__('Hủy!')}}",
                  closeOnConfirm: false,
                  closeOnCancel: false
              },
              function(isConfirm) {
                  if (isConfirm) {
                    var shipping_name = $('.shipping_name').val();
                    var shipping_city = $('.shipping_city').val();
                    var shipping_address = $('.shipping_address').val();
                    var shipping_phone = $('.shipping_phone').val();
                    var shipping_email = $('.shipping_email').val();
                    var shipping_note = $('.shipping_note').val();
                    var shipping_method = $("input[name='payment']:checked").val();
                    var order_fee = $('.order_fee').val();
                    var order_coupon = $('.order_coupon').val();
                    var _token = $('input[name="_token"]').val();

                    console.log("Shipping name:", shipping_name);
                    console.log("Shipping city:", shipping_city);
                    console.log("Shipping address:", shipping_address);
                    console.log("Shipping phone:", shipping_phone);
                    console.log("Shipping email:", shipping_email);
                    console.log("Shipping note:", shipping_note);
                    console.log("Shipping method:", shipping_method);
                    console.log("Order fee:", order_fee);
                    console.log("Order coupon:", order_coupon);
                    console.log("Token:", _token);

                    // {{-- Kiểm tra thông tin --}}
                    

                    if (shipping_name == '' || shipping_city == '' || shipping_address == '' || shipping_phone == '' || shipping_email == '') {
                        swal("{{__('Lỗi!')}}", "{{__('Vui lòng điền đầy đủ thông tin để đặt hàng')}}", "warning");
                        return false;
                    }
                    if (shipping_method == undefined) {
                        swal("{{__('Lỗi!')}}", "{{__('Vui lòng chọn phương thức thanh toán')}}", "warning");
                        return false;
                    }

                      if (shipping_method == 0) {
                        $.ajax({
                        url : '{{url('/payment-online')}}',
                        method: 'POST',
                        data:{shipping_name:shipping_name,shipping_city:shipping_city,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_email:shipping_email,shipping_note:shipping_note,shipping_method:shipping_method,order_fee:order_fee,order_coupon:order_coupon,_token:_token},
                        success:function(){
                         $(location).attr('href', 'thanh-toan');
                        }
                        });
                    }else{
                    $.ajax({
                        url : '{{url('/save-order')}}',
                        method: 'POST',
                        data:{shipping_name:shipping_name,shipping_city:shipping_city,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_email:shipping_email,shipping_note:shipping_note,shipping_method:shipping_method,order_fee:order_fee,order_coupon:order_coupon,_token:_token},
                        success:function(){
                         swal("{{__('Đơn hàng !')}}", "{{__('Cảm ơn bạn đã đặt hàng, đơn hàng của bạn đang được xử lý !')}}", "success");
                             window.setTimeout(function(){
                                location.reload();
                            },3000);
                        },error:function(){
                         swal("{{__('vui lòng !')}}", "{{__('Cảm ơn bạn đã đặt hàng, đơn hàng của bạn đang được xử lý !')}}", "success");
                        }
                    });
                    
                    } 
                    
                } else {
                    swal("{{__('Hủy!')}}", "{{__('Đơn hàng của bạn chưa được đặt')}}", "error");
                }
            });
        });
    });
    </script>
    {{-- end send-order --}}
    <script type="text/javascript">

// Mỗi tỉnh thành có một mã code duy nhất, dựa vào đó để xác định vị trí của tỉnh thành trên bản đồ
const provinceCoordinate = [
  { name: "An Giang", code: 89, lat: 10.5216, lng: 105.1259 },
  { name: "Bà Rịa - Vũng Tàu", code: 77, lat: 10.5417, lng: 107.2428 },
  { name: "Bắc Giang", code: 24, lat: 21.281, lng: 106.1976 },
  { name: "Bắc Kạn", code: 6, lat: 22.147, lng: 105.8348 },
  { name: "Bạc Liêu", code: 95, lat: 9.294, lng: 105.7272 },
  { name: "Bắc Ninh", code: 27, lat: 21.1862, lng: 106.0763 },
  { name: "Bến Tre", code: 83, lat: 10.2434, lng: 106.3757 },
  { name: "Bình Định", code: 52, lat: 13.782, lng: 109.2197 },
  { name: "Bình Dương", code: 74, lat: 11.1334, lng: 106.6558 },
  { name: "Bình Phước", code: 70, lat: 11.7512, lng: 106.7235 },
  { name: "Bình Thuận", code: 60, lat: 11.0904, lng: 108.0721 },
  { name: "Cà Mau", code: 96, lat: 9.1768, lng: 105.1524 },
  { name: "Cần Thơ", code: 92, lat: 10.0452, lng: 105.7469 },
  { name: "Cao Bằng", code: 4, lat: 22.6655, lng: 106.257 },
  { name: "Đà Nẵng", code: 48, lat: 16.0544, lng: 108.2022 },
  { name: "Đắk Lắk", code: 66, lat: 12.71, lng: 108.2378 },
  { name: "Đắk Nông", code: 67, lat: 12.2539, lng: 107.6098 },
  { name: "Điện Biên", code: 11, lat: 21.386, lng: 103.023 },
  { name: "Đồng Nai", code: 75, lat: 10.9453, lng: 106.824 },
  { name: "Đồng Tháp", code: 87, lat: 10.4576, lng: 105.6324 },
  { name: "Gia Lai", code: 64, lat: 13.8079, lng: 108.1094 },
  { name: "Hà Giang", code: 2, lat: 22.824, lng: 104.9836 },
  { name: "Hà Nam", code: 35, lat: 20.583, lng: 105.9229 },
  { name: "Hà Nội", code: 1, lat: 21.0285, lng: 105.8544 },
  { name: "Hà Tĩnh", code: 42, lat: 18.3428, lng: 105.9057 },
  { name: "Hải Dương", code: 30, lat: 20.939, lng: 106.3306 },
  { name: "Hải Phòng", code: 31, lat: 20.8449, lng: 106.6881 },
  { name: "Hậu Giang", code: 93, lat: 9.7579, lng: 105.641 },
  { name: "Hòa Bình", code: 17, lat: 20.8584, lng: 105.3376 },
  { name: "Hưng Yên", code: 33, lat: 20.6464, lng: 106.0511 },
  { name: "Khánh Hòa", code: 56, lat: 12.2436, lng: 109.1967 },
  { name: "Kiên Giang", code: 91, lat: 10.0122, lng: 105.08 },
  { name: "Kon Tum", code: 62, lat: 14.349, lng: 108.0 },
  { name: "Lai Châu", code: 12, lat: 22.3954, lng: 103.4589 },
  { name: "Lâm Đồng", code: 68, lat: 11.9416, lng: 108.4419 },
  { name: "Lạng Sơn", code: 20, lat: 21.8537, lng: 106.7615 },
  { name: "Lào Cai", code: 10, lat: 22.48, lng: 103.9738 },
  { name: "Long An", code: 80, lat: 10.5438, lng: 106.4113 },
  { name: "Nam Định", code: 36, lat: 20.4387, lng: 106.1621 },
  { name: "Nghệ An", code: 40, lat: 19.2342, lng: 104.9204 },
  { name: "Ninh Bình", code: 37, lat: 20.2539, lng: 105.9745 },
  { name: "Ninh Thuận", code: 58, lat: 11.5671, lng: 108.9886 },
  { name: "Phú Thọ", code: 25, lat: 21.3792, lng: 105.2197 },
  { name: "Phú Yên", code: 54, lat: 13.0882, lng: 109.0929 },
  { name: "Quảng Bình", code: 44, lat: 17.4689, lng: 106.6223 },
  { name: "Quảng Nam", code: 49, lat: 15.5393, lng: 108.0192 },
  { name: "Quảng Ngãi", code: 51, lat: 15.1214, lng: 108.8076 },
  { name: "Quảng Ninh", code: 22, lat: 21.0064, lng: 107.2925 },
  { name: "Quảng Trị", code: 45, lat: 16.8183, lng: 107.0928 },
  { name: "Sóc Trăng", code: 94, lat: 9.6031, lng: 105.9783 },
  { name: "Sơn La", code: 14, lat: 21.3258, lng: 103.9188 },
  { name: "Tây Ninh", code: 72, lat: 11.3606, lng: 106.0989 },
  { name: "Thái Bình", code: 34, lat: 20.45, lng: 106.3402 },
  { name: "Thái Nguyên", code: 19, lat: 21.5956, lng: 105.844 },
  { name: "Thanh Hóa", code: 38, lat: 19.8072, lng: 105.776 },
  { name: "Thừa Thiên Huế", code: 46, lat: 16.4637, lng: 107.5909 },
  { name: "Tiền Giang", code: 82, lat: 10.3759, lng: 106.3435 },
  { name: "TP. Hồ Chí Minh", code: 79, lat: 10.7769, lng: 106.7009 },
  { name: "Trà Vinh", code: 84, lat: 9.8127, lng: 106.3454 },
  { name: "Tuyên Quang", code: 8, lat: 21.8231, lng: 105.214 },
  { name: "Vĩnh Long", code: 86, lat: 10.2533, lng: 105.9722 },
  { name: "Vĩnh Phúc", code: 26, lat: 21.3086, lng: 105.6049 },
  { name: "Yên Bái", code: 15, lat: 21.7051, lng: 104.8705 },
];

// Hàm tính phí vận chuyển dựa trên khoảng cách giữa hai tỉnh thành
// Vì chi nhánh nằm ở Cần Thơ (code: 92), nên ta sẽ lấy tọa độ của Cần Thơ làm điểm xuất phát 
// Hàm này sẽ được gọi mỗi khi người dùng chọn tỉnh thành mới 
function calculateShippingFee(selectedProvinceCode) {
    const origin = provinceCoordinate.find((item) => item.code === 92); // Cần Thơ
    const destination = provinceCoordinate.find((item) => item.code == selectedProvinceCode);
    if (!origin || !destination) {
        console.error("Origin or destination not found");
        return;
    }

    // Nếu tỉnh được chọn là Cần Thơ, không cần tính phí vận chuyển
    if (selectedProvinceCode == 92) {
        var fee = 0;
        updateFeeUIAndSession(fee);
        return;
    }

    fetch('https://api.openrouteservice.org/v2/directions/driving-car/geojson', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': '5b3ce3597851110001cf62482b8c81c62e6f48a48ec0c0f4f1107e04'
        },
        body: JSON.stringify({
            coordinates: [
                [origin.lng, origin.lat],
                [destination.lng, destination.lat]
            ],
            profile: 'driving-car'
        })
    })
    .then(res => res.json())
    .then(data => {
        const km = data.features[0].properties.summary.distance / 1000;
        let fee = 0;
        if (km < 30) fee = 15000;
        else if (km < 50) fee = 25000;
        else if (km < 70) fee = 30000;
        else if (km < 100) fee = 35000;
        else if (km <= 100) fee = 35000;
        else fee = 40000;
        updateFeeUIAndSession(fee);
    })
    .catch(error => {
        console.error("Error fetching distance:", error);
        alert('Không thể tính phí vận chuyển. Vui lòng thử lại!');
    });
}

function updateFeeUIAndSession(fee) {
    // Cập nhật hiển thị phí vận chuyển trên giao diện
    $(".order_fee").val(fee);
    $("#shipping-fee").text(fee.toLocaleString() + ' VND');
    // Cập nhật phí vận chuyển vào session thông qua AJAX
    $.ajax({
        url: '/set-fee',
        method: 'POST',
        data: {
            fee: fee,
            _token: $('input[name="_token"]').val()
        },
        success: function(response) {
            console.log('Order fee updated in session:', response);
            // alert('Phí vận chuyển đã được cập nhật thành công!');
        },
        error: function(xhr) {
            alert('Lỗi khi cập nhật phí vận chuyển!');
        }
    });
}

// Mỗi khi thay đổi thành phố/tỉnh, sẽ tính toán lại phí vận chuyển tự động không cần phải ấn nút "Tính phí"
    $(document).ready(function() {
        $('.city').on('change', function() {
            const selectedProvinceCode = $(this).val();
            if (selectedProvinceCode) { // Nếu đã chọn tỉnh thành, gọi hàm tính phí
                calculateShippingFee(selectedProvinceCode); // Goị hàm tính phí ở trên
            } else { // Nếu không chọn tỉnh thành nào, đặt phí vận chuyển về 0
            // $(".order_fee").val(0); 
            // $("#shipping-fee").text('0 VND');
        }
        $('#calculate').on('click', function() {
            var shippingData = {
    shipping_name: $('.shipping_name').val(),
    shipping_city: $('.shipping_city').val(),
    shipping_address: $('.shipping_address').val(),
    shipping_phone: $('.shipping_phone').val(),
    shipping_email: $('.shipping_email').val(),
    shipping_note: $('.shipping_note').val(),
    payment: $('input[name="payment"]:checked').val(),
    fee: $('.order_fee').val(),
    _token: $('input[name="_token"]').val() };
     console.log("Shipping name:", shippingData);
$.ajax({
    url: '/set-shipping-session',
    method: 'POST',
    data: shippingData,
    success: function(response) {
        // reload trang để cập nhật thông tin giao hàng
        location.reload();
    },
    error: function(xhr) {
        alert('Lỗi khi lưu thông tin giao hàng!');
    }
});
        });
    });
});
    </script>
    <script type="text/javascript">
</script>
@include('partials.chatbot-widget')
</body>

</html>