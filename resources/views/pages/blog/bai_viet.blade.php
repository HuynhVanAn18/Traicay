@extends('layout')
@section('content')
<!-- Blog Details Hero Begin -->
    <section class="breadcrumb-section set-bg owl-carousel owl-loaded owl-drag" style="margin-left: 100px;width: 1150px;height: 150px;" data-setbg="{{URL::to('frontend/image/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog__details__hero__text">
                      {{--   slider --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5 order-md-1 order-2">
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
                <div class="col-lg-8 col-md-7 order-md-1 order-1">
                    @foreach($post as $key => $p )
                    <div class="blog__details__text">
                        <h2>{{$p->post_title}}</h2>
                        </br>
                        <center><img src="{{asset('upload/post/'.$p->post_image)}}" alt=""></center>
                        <p>{!!$p->post_content!!}</p>
                    </div>
                    <div class="blog__details__content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="blog__details__author">
                                    <div class="blog__details__author__pic">
                                    </div>
                                    <div class="blog__details__author__text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="blog__details__widget">
                                   {{--  <ul>@foreach($category_blog as $key=> $cate)
                                        <li><span>Danh Mục Bài Viết: </span>{{$cate->cate_blog_name}}</li>
                                        <li><span>Tags: </span>{{$meta_keywords}}</li>
                                        @endforeach
                                    </ul> --}}
                                    <div class="blog__details__social">
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-google-plus"></i></a>
                                        <a href="#"><i class="fa fa-linkedin"></i></a>
                                        <a href="#"><i class="fa fa-envelope"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <!-- Related Blog Section Begin -->
    <section class="related-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related-blog-title">
                        <h2>Bài Viết Liên Quan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($post_related as $key => $related)
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('upload/post/'.$related->post_image)}}" width="360" height="258" alt="{{$related->post_slug}}">
                        </div>
                        <div class="blog__item__text">
                            <h5><a href="{{URL::to('/bai-viet/'.$related->post_slug)}}">{{$related->post_title}}</a></h5>
                            <p>{{$related->post_desc}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Blog Section End -->
@endsection