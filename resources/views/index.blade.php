@extends('template')

@section('content')


<section id="feature" >
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Новостной парcер</h2>
        </div>

        <table id="news" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>Название</th>
                <th>Теги</th>
                <th>Дата</th>
                <th>Просмотров</th>
            </tr>
            </thead>
            <tbody>

            @foreach($content as $news)
                <tr>
                    <td>
                        <a href="{{$news->link}}">
                            {{$news->title}}
                        </a>
                    </td>
                    <td>{{$news->tags}}</td>
                    <td>{{$news->date}}</td>
                    <td>{{$news->views}}</td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>Название</th>
                <th>Теги</th>
                <th>Дата</th>
                <th>Просмотров</th>
            </tr>
            </tfoot>
        </table>

    </div><!--/.container-->
</section><!--/#feature-->



@endsection