<aside class="control-sidebar control-sidebar-dark">
    <!-- Ngapain disini bang? Gabut bat awokawok. -->
</aside>
<footer class="main-footer">
    <div class="row">
        <div class="col-md-5">
            <h3>{{ config('app.name', 'vTual') }}</h3>
            <div class="pr-lg-5">
                <p>The {{ config('app.name', 'vTual') }} network is a project designed to simplify the process of keeping up with your favorite content creators activity across platform; All in one convenient portal.</p>
                <details class="my-3">
                    <summary>More Information...</summary>
                    <p>If you are a content creator, join us so that we can feature your content on our platform, allowing it to be seen by a larger audience. By becoming part of our community, you can expand your reach and engage with more viewers who are eager to discover and enjoy your work.</p>
                    <p>If you are a viewer, join us to receive the latest updates about your favorite content creators, or even discover new and promising creators. By becoming part of our community, you can stay informed and explore a wide range of content that caters to your interests.</p>
                </details>
                <p><small>Copyright &copy; 2024. The {{ config('app.name', 'vTual') }} Project (build {{ config('app.version', 'v.??.??') }}) by <a href="https://www.silverspoon.me" class="text-light" target="_blank">Silverspoon Media</a>. All rights reserved.</small></p>
            </div>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-12 col-md-4">
                    <h4>Internal</h4>
                    <ul class="list-unstyled">
                        <li>
                            <a href="https://help.silverspoon.me/docs/vtual/about" target="_blank" class="text-light">About Us</a>
                        </li>
                        <li>
                            <a href="https://help.silverspoon.me/blog/tags/v-tual" target="_blank" class="text-light">Blog Post</a>
                        </li>
                        <li>
                            <a href="https://help.silverspoon.me/docs/silverspoon/contact" target="_blank" class="text-light">Contact Us</a>
                        </li>
                        <li>
                            <a href="https://help.silverspoon.me/docs/category/vtual" target="_blank" class="text-light">Get, Get Some Help</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-md-4">
                    <h4>Legal</h4>
                    <ul class="list-unstyled">
                        <li>
                            <a href="https://help.silverspoon.me/docs/vtual/tos" target="_blank" class="text-light">Terms of Service</a>
                        </li>
                        <li>
                            <a href="https://help.silverspoon.me/docs/vtual/privacy" target="_blank" class="text-light">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="https://help.silverspoon.me/docs/silverspoon/report" target="_blank" class="text-light">Report</a>
                        </li>
                        <li>
                            <a href="https://help.silverspoon.me/docs/silverspoon/feedback" target="_blank" class="text-light">Feedback</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-md-4">
                    <h4>External</h4>
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('go.bsky') }}" target="_blank" class="text-light">Bluesky</a>
                        </li>
                        <li>
                            <a href="#" class="text-light">Discord</a>
                        </li>
                        <li>
                            <a href="{{ route('go.status') }}" target="_blank" class="text-light">Status History</a>
                        </li>
                        <li>
                            <a href="{{ route('go.ping') }}" target="_blank" class="text-light">Status Ping</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>