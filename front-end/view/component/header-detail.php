<?php
function getHeader($hint, $pagename)
{
    echo '
    <div class="header-page">
        <div class="col-lg-10 col-md-10 col-sm-12">
            <button class="btn btn-back">&#8826; Back</button>
            <div class="title-header">
                <h2>
                    ' . $hint . '
                </h2>
            </div>
            <div class="title-header-desc">
              ' . $pagename . '
            </div>
        </div>
    </div>';
}
