<footer class="footer footer-static footer-dark navbar-border navbar-shadow no-print" style="background: #222751 !important;">
    <p class="clearfix text-center mb-0 px-2 alarm-upgrade justify-content-center text-white w-100">
        @if ($user->company->subscription->type->type_name == 'تجربة')
            {{ __('main.you-are-now-in-the-beta-version') }} - {{ __('main.remaining-time') }}
            <?php
            $subscription_type = $user->company->subscription->type->type_name;
            if ($subscription_type == 'تجربة') {
                $now = time(); // or your date as well
                $your_date = strtotime($user->company->subscription->end_date);
                $datediff = $your_date - $now;
                echo round($datediff / (60 * 60 * 24));
            }
            ?>
            {{ __('main.day') }}, {{ __('main.to-end-the-trial-version') }}
            <a role="button" class="ml-2 btn btn-md btn-outline-success" href="{{ route('go.to.upgrade') }}">
                {{ __('main.upgrade-now') }}
            </a>
        @else
            أنت الان فى النسخة المفعلة
            {{ $user->company->subscription->type->package->package_name }}
            ( {{ $user->company->subscription->type->type_name }} )
            - الوقت المتبقى
            <?php
            $subscription_type = $user->company->subscription->type->type_name;
            $now = time(); // or your date as well
            $your_date = strtotime($user->company->subscription->end_date);
            $datediff = $your_date - $now;
            echo round($datediff / (60 * 60 * 24));

            ?>
            يوم لانتهاء النسخة
            <br>
            تاريخ انتهاء النسخة الحالية :
            ( {{ $user->company->subscription->end_date }} )
        @endif
    </p>
</footer>

