
<h5>Patients</h5>

<div id="toggleAccordion">
    @foreach($patients as $key => $patient)
    <div class="card">
        <div class="card-header" id="...">
            <section class="mb-0 mt-0">
                <div role="menu" class="collapsed" data-toggle="collapse" data-target="#defaultAccordion{{ $key }}" aria-expanded="true" aria-controls="defaultAccordion{{ $key }}">
                    POI: #<b>{{ $patient->poi_id }}</b>
                </div>
            </section>
        </div>
        <div id="defaultAccordion{{ $key }}" class="collapse" aria-labelledby="" data-parent="#toggleAccordion">
            <div class="card-body">
                <h6>
                    Patient Data
                    <button class="btn btn-sm btn-primary float-right">Notify LGU for Test</button>
                </h6><br>

                @php 
                    $dailyTotals = \App\Models\ChecklistDailyTotal::findByPoi($patient->poi_id)->get();
                    $severe = \App\Models\ChecklistDailyTotal::findByPoi($patient->poi_id)->condition('Severe Condition')->get();
                    $mild = \App\Models\ChecklistDailyTotal::findByPoi($patient->poi_id)->condition('Mild Condition')->get();
                    $good = \App\Models\ChecklistDailyTotal::findByPoi($patient->poi_id)->condition('Good Condition')->get();

                @endphp

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="widget widget-one_hybrid widget-referral" style="background-color: #ffbec0 !important;">
                            <div class="widget-heading">
                                <p class="w-value">
                                    Severe Condition
                                    <span class="float-right">{{ $severe->count() }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
                        <div class="widget widget-one_hybrid widget-followers" style="background-color: #ffd8c0;">
                            <div class="widget-heading">
                                <p class="w-value">
                                    Mild Condition
                                    <span class="float-right">{{ $mild->count() }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
                        <div class="widget widget-one_hybrid widget-engagement" style="background-color: #d0ff88;">
                            <div class="widget-heading">
                                <p class="w-value">
                                    Good Condition
                                    <span class="float-right">{{ $good->count() }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

               {{--  <hr>
                Top most common on Daily Health Checklist
                <ul>
                    <ol></ol>
                    <ol></ol>
                    <ol></ol>
                    <ol></ol>
                    <ol></ol>
                </ul> --}}
            </div>
        </div>
    </div>
    @endforeach

</div>