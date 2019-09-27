<div aria-live="polite" aria-atomic="true" style="position: relative; z-index: 1;">
        <div style="backdrop-filter: blur(5px);  position: absolute; right: 0;">
            @if($errors->any())
                @foreach ($errors->all() as $error)
                <div class="toast" data-autohide="true" data-delay="10000" data-animation="true" role="alert" aria-live="assertive">
                    <div class="toast-header">
                        <img src="{{ url('svg/BSSHSA.jpg') }}" width="30" class="rounded mr-2" alt="">
                        <strong class="mr-auto">БСШСА</strong>
                        <small>{{ (new \DateTime())->format('H:i d.m.Y') }}</small>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                </div>
                @endforeach
            @elseif(session('message'))
                <div class="toast" data-autohide="true" data-delay="10000" data-animation="true" role="alert"
                     aria-live="assertive">
                    <div class="toast-header">
                        <img src="{{ url('svg/BSSHSA.jpg') }}" width="30" class="rounded mr-2" alt="">
                        <strong class="mr-auto">БСШСА</strong>
                        <small>{{ (new \DateTime())->format('H:i d.m.Y') }}</small>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
        </div>
</div>
