<x-app-marketing-layout>
    @section('pageTitle', 'Blog')
<div class="blog">
    <div class="container">
        <div class="blog_section main_blog">
            <div class="title_box">
                <h3>{{ __('Latest News and Blog') }}</h3>
                <p>{{ __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent convallis viverra ante a consectetur.') }}</p>
            </div>
            <div class="blog_wrap" id="load-more-ajax">

            </div>

            {{-- me division muko chhe
                <div class="btnbox"><a href="#" class="primary-btn load-more-btn">load more</a></div>
            --}}

        </div>
    </div>
</div>

@section('custom_script')
    <script>
        let route = "{{ route('blog.ajax-load-more') }}";
        var page = 1
        $(document).ready(function() {
            console.log('yyy');
            loadMoreBlogs();
            $(document).on('click', '.load-more-btn', function (e) {
                e.preventDefault();
                page++;
                loadMoreBlogs(page);
            });
        });

        function loadMoreBlogs(page = 1) {
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-Token': "{{ csrf_token() }}",
                },
                url: route + '?page=' + page,
                data: '',
                success: function (res) {
                    if (res.success) {
                        console.log(res.message);
                        $('#load-more-ajax').append(res.blogsHtml);
                        if (!res.hasMorePages) {
                            $('.load-more-btn').hide();
                        }
                    }
                    else {
                        alert('Error '+ res.status + ': ' + res.message);
                    }
                }
            });
        }
    </script>
@endsection
</x-app-marketing-layout>