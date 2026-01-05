<style>
    @media all {
        @font-face {
            font-family: 'muol';
            src: url('{{ asset('assets/fonts/prints/khmer-os-muollight.ttf') }}');
        }

        @font-face {
            font-family: 'Times New Roman';
            src: url('{{ asset('assets/fonts/prints/times-new-roman.ttf') }}');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Times New Roman';
            src: url('{{ asset('assets/fonts/prints/times-new-roman-bold.ttf') }}');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Times New Roman';
            src: url('{{ asset('assets/fonts/prints/times-new-roman-italic.ttf') }}');
            font-weight: bold;
            font-style: italic;
        }

        @font-face {
            font-family: 'battambang';
            src: url('{{ asset('assets/fonts/prints/khmer-os-battambang.ttf') }}');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'battambang';
            src: url('{{ asset('assets/fonts/prints/khmer-os-battambang.ttf') }}');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Battambang Bold';
            src: url('{{ asset('assets/fonts/battambang/Battambang-Bold.ttf') }}');
            font-weight: bold !important;
            font-style: normal !important;
        }

        .battambang {
            font-family: 'Times New Roman', 'battambang', sans-serif !important;
        }

        .muol {
            font-family: 'Times New Roman', 'muol', sans-serif !important;
        }

        .times {
            font-family: 'Times New Roman', sans-serif !important;
        }

        .text-bold {
            font-weight: bold !important;
        }

        .battambang.text-bold {
            font-family: 'Times New Roman', 'Battambang Bold' !important;
            font-weight: bold !important;
        }
    }
</style>
