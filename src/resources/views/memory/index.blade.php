@extends('adminlte::page')

@section('title', '日記一覧')

@section('content_header')
    <h1>日記一覧</h1>
@stop

@section('content')
    <p>1日を50文字と画像1枚で表現してみましょう。</p>    
     <!-- Main content -->
    <section class="content">
    @if (session('success'))
      <div class="alert alert-success">
            {{ session('success') }}
      </div>
    @endif
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <div class="row">
                  <div class="offset-11 col-1">
                      <a href="{{ route('memory.add') }}"
        						class="btn btn-primary text-light">新規</a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class="col-1">日付</th>
                    <th class="col-2">画像</th>
                    <th class="col-8">日記</th>
                    <th class="col-1"></th>
                  </tr>
                  </thead>
                  <tbody>
                @foreach($memories as $memory)
                  <tr>
                    <td>{{ str_replace('-', '/', $memory->recorded_date) }}</td>
                    <td></td>
                    <td>{{ $memory->sentence }}</td>
                    <td>
                       <div class="mb-3">
                    		<a href="{{ route('memory.edit', ['memory' => $memory->id]) }}"
        						class="btn btn-secondary text-light">編集</a>
                       </div>
                       <div class="float-left mr-2">
                            <form action="{{ route('memory.delete', ['memory' => $memory->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-light" onclick="return window.confirm('本当に削除しますか？');">削除</button>
                            </form>
                        </div>
                    </td>
                  </tr>
                @endforeach
                  </tbody>                 
                </table>
                <div class="pagination">
					{{ $memories->links('pagination.custom') }} 
				</div>
              </div>
              <!-- /.card-body --> 
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop