<style>
    .content-header {
        margin-top: -30px;
    }

    .content-header .container-fluid {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 20px 30px;
        box-shadow: 0 3px 50px rgba(0, 0, 0, 0.1);
        /* transition: all 0.3s ease-in-out; */
        width: 100%;
    }

    .content-header h1 {
        font-size: 32px;
        font-weight: bold;
        color: #5c2f0b;
        margin-bottom: 0;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0;
        font-size: 16px;
    }

    .breadcrumb-item a {
        color: #5c2f0b;
        font-weight: bold;
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: #5c2f0b;
        text-decoration: underline;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›"; /* gaya modern panah */
        color: #6c757d;
        padding: 0 8px;
    }

    .breadcrumb-item {
        color: #6c757d;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1>{{ $breadcrumb->title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/dashboard') }}"><i class="fas fa-home"></i> Home</a>
                    </li>
                    @foreach ($breadcrumb->list as $key => $value)
                        @php
                            $name = is_array($value) ? $value['name'] : $value;
                        @endphp

                        @if (strtolower($name) != 'home')
                            <li class="breadcrumb-item">
                                {{ htmlspecialchars($name) }}
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>
