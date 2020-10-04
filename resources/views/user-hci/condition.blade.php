<div class="row layout-top-spacing">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-referral" style="background-color: #ffbec0 !important;">
            <div class="widget-heading">
                <p class="w-value">
                    Severe Condition
                    <span class="float-right">{{ $conditions['severe']->count() }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-followers" style="background-color: #ffd8c0;">
            <div class="widget-heading">
                <p class="w-value">
                    Mild Condition
                    <span class="float-right">{{ $conditions['mild']->count() }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-engagement" style="background-color: #d0ff88;">
            <div class="widget-heading">
                <p class="w-value">
                    Good Condition
                    <span class="float-right">{{ $conditions['good']->count() }}</span>
                </p>
            </div>
        </div>
    </div>
</div>