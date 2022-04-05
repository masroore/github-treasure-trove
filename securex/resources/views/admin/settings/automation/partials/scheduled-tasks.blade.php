<div class="card" id="access-card">
    <div class="card-header bg-white">
        <div class="col-8">
            <h4>{{ __('admin.settings.scheduled_tasks') }}</h4>

        </div>
        <div class="col-4 text-right">
            <a class="btn btn-primary collapsed" data-toggle="collapse" href="#tasksCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                Show / Hide Settings
            </a>
        </div>
    </div>
    <div class="collapse show" id="tasksCollapse">
        <div class="card-body bg-secondary">
            <p class="text-muted">{{ __('admin.settings.scheduled_tasks_sub') }}</p>
            <!-- Task 1 -->
            <div class="form-group row align-items-center">
                <label for="access" class="form-control-label col-sm-3 text-md-right">
                    1. {{ __('admin.settings.deletion_checker') }}
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('admin.settings.deletion_checker_help') }}"><i class="fas fa-question-circle text-primary"></i></span>
                </label>
                <div class="col-sm-6 col-md-9">
                    @if($adc_task)
                    <button type="button" class="btn btn-warning">
                        <?php $next_run_adc = $adc_task->ran_at->addHours(12); ?>
                        {{ __('admin.settings.scheduled_in', ['eta' => $next_run_adc->diffForHumans() ]) }} <span class="badge badge-transparent"><i class="fas fa-trash-alt"></i></span>
                    </button>
                    <button type="button" class="btn btn-success">
                        {{ __('admin.settings.last_ran', ['time' => $adc_task->ran_at->diffForHumans() ]) }} <span class="badge badge-transparent"><i class="fas fa-check"></i></span>
                    </button>
                    @else
                    <button type="button" class="btn btn-danger">
                        {{ __('admin.settings.task_not_executed') }} <span class="badge badge-transparent"><i class="fas fa-times"></i></span>
                    </button>
                    @endif
                </div>
            </div>
            <!-- Task 2 -->
            <div class="form-group row align-items-center">
                <label for="access" class="form-control-label col-sm-3 text-md-right">
                    2. {{ __('admin.settings.auth_log_cleaner') }}
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('admin.settings.auth_log_cleaner_help') }}"><i class="fas fa-question-circle text-primary"></i></span>
                </label>
                <div class="col-sm-6 col-md-9">
                    @if($alc_task)
                    <button type="button" class="btn btn-warning">
                        <?php $next_run_alc = $alc_task->ran_at->addHours(24); ?>
                        {{ __('admin.settings.scheduled_in', ['eta' => $next_run_alc->diffForHumans() ]) }} <span class="badge badge-transparent"><i class="fas fa-trash-alt"></i></span>
                    </button>
                    <button type="button" class="btn btn-success">
                        {{ __('admin.settings.last_ran', ['time' => $alc_task->ran_at->diffForHumans() ]) }} <span class="badge badge-transparent"><i class="fas fa-check"></i></span>
                    </button>
                    @else
                    <button type="button" class="btn btn-danger">
                        {{ __('admin.settings.task_not_executed') }} <span class="badge badge-transparent"><i class="fas fa-times"></i></span>
                    </button>
                    @endif
                </div>
            </div>
            @if(setting()->get('db_mysql_dump_path') != null)
            <!-- Task 3 -->
            <div class="form-group row align-items-center">
                <label for="access" class="form-control-label col-sm-3 text-md-right">
                    3. {{ __('admin.settings.db_backup') }}
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('admin.settings.auth_log_cleaner_help') }}"><i class="fas fa-question-circle text-primary"></i></span>
                </label>
                <div class="col-sm-6 col-md-9">
                    @if($backup_task)
                    @if($backup_task->status == 'Failed')
                    <button type="button" class="btn btn-warning">
                        {{ __('admin.settings.db_backup_failed') }} <span class="badge badge-transparent"><i class="fas fa-times"></i></span>
                    </button>
                    @elseif($backup_task->status == 'Success')
                    <button type="button" class="btn btn-warning">
                        <?php $next_run_backup = $backup_task->ran_at->addHours(24); ?>
                        {{ __('admin.settings.scheduled_in', ['eta' => $next_run_backup->diffForHumans() ]) }} <span class="badge badge-transparent"><i class="fas fa-trash-alt"></i></span>
                    </button>
                    <button type="button" class="btn btn-success">
                        {{ __('admin.settings.last_ran', ['time' => $backup_task->ran_at->diffForHumans() ]) }} <span class="badge badge-transparent"><i class="fas fa-check"></i></span>
                    </button>
                    @endif
                    @else
                    <button type="button" class="btn btn-danger">
                        {{ __('admin.settings.task_not_executed') }} <span class="badge badge-transparent"><i class="fas fa-times"></i></span>
                    </button>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
