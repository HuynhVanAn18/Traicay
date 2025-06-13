@extends('layout')
@section('content')
     <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg owl-carousel owl-loaded owl-drag" style="margin-left: 100px;width: 1150px;height: 150px;" data-setbg="{{URL::to('frontend/image/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <div class="breadcrumb__option">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Danh Mục Bài Viết</h4>
                            <ul>
                                @foreach($category_blog as $key =>$blog)
                                <li><a href="{{URL::to('danh-muc-bai-viet/'.$blog->cate_blog_slug)}}">{{$blog->cate_blog_name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Bài Viết Mới</h4>
                            <div class="blog__sidebar__recent">
                                @foreach($post_new as $key =>$new)
                                <a href="{{URL::to('/bai-viet/'.$new->post_slug)}}" class="blog__sidebar__recent__item">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img height="70" width="70" src="{{asset('upload/post/'.$new->post_image)}}" alt="{{$new->post_slug}}">
                                    </div>
                                    <div class="blog__sidebar__recent__item__text">
                                        <h6>{{$new->post_title}}</h6>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="row">
                        @foreach($post as $key => $p )
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="{{asset('upload/post/'.$p->post_image)}}" width="360" height="258" alt="{{$p->post_slug}}">
                                </div>
                                <div class="blog__item__text">
                                    <h5><a href="{{URL::to('/bai-viet/'.$p->post_slug)}}">{{$p->post_title}}</a></h5>
                                    <p>{{$p->post_desc}}</p>
                                    <a href="{{URL::to('/bai-viet/'.$p->post_slug)}}" class="blog__btn">Xem bài viết <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-lg-12">
                            <span>{!!$post->links()!!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
