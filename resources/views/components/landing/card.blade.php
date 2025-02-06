<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
        <div class="team-member">
            <img
                src="{{ $foto_path }}"
                alt="Image"
                class="img-fluid" />
            <div class="text" style="width: 100%">
                <h2 class="mb-2 font-weight-light h4">{{ $nome }}</h2>
                <p>
                    <a
                        href="{{ $facebook_link }}"
                        target="_blank"
                        class="text-white p-2">
                        <span class="icon-facebook"></span>
                    </a>
                    <a
                        href="{{ $x_link }}"
                        target="_blank"
                        class="text-white p-2">
                        <span class="icon-twitter"></span>
                    </a>
                    <a
                        href="{{ $instagram_link }}"
                        target="_blank"
                        class="text-white p-2">
                        <span class="icon-instagram"></span>
                    </a>
                </p>
            </div>
        </div>
        <p class="text-center font-weight-light h4">{{ $nome }}</p>
    </div>
</div>
