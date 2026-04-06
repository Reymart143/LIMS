@include('layouts.header')
  @include('layouts.sidebar')
    @include('layouts.navbar')
      <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
      @yield('content')
@include('layouts.footer')
  