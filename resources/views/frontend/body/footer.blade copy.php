<footer>

    @forelse($footer as $foot)
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h4>{{ $foot->name }}</h4>
                    <p>
                        {!! $foot->address !!}
                    </p>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
        <div class="social-media text-center">
            @foreach ($line as $item)
                <div class="icon" style="text-align: center;">
                    <a data-toggle="modal" data-target="#lineModalCenter">
                        <span class=""><i class="{{ $item->icon }}"
                                style="color: {!! $item->color !!}; font-size:22px"></i>
                        </span>
                    </a>
                </div>

                {{-- line modal  --}}
                <div class="modal fade" id="lineModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="lineModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="display:flex; align-items:center; justify-content:center">
                                <h5 class="modal-title" style="color:rgb(41, 193, 41)">I-Tech Line QR code</h5>
                            </div>
                            <div class="modal-body">
                                <div class="qrcode">
                                    {!! QrCode::size(300)->generate($item->url) !!}
                                </div>
                                <p class="text-black mt-2">{{ $item->url }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                        class="fas fa-times"></i>&nbsp;&nbsp;Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @forelse ($social as $item)
                <div class="icon">
                    <a href="{{ $item->url }}" target="_blank">
                        <span>
                            <i class="{{ $item->icon }}" style="color: {!! $item->color !!}; font-size:22px"></i>
                        </span>
                    </a>
                </div>

            @empty
                <div style="width:100%">
                    No social media data!!
                </div>
            @endforelse
        </div>
    @empty
        <div class="center">
            No Footer data !!
        </div>
    @endforelse
</footer>
