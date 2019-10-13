function getData(placeholder, url, type) {
    return {
        placeholder: placeholder,
        allowClear: true,
        ajax: {
            url: url,
            dataType: 'json',
            delay: 200,
            data: function (params) {
                return {
                    q: params.term,
                    id: $('#bahan_id').val(),
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 10) < data.total
                    }
                };
            }
        },
        minimumInputLength: 2,
        templateResult: function (repo) {
            console.log(repo)
            if (repo.loading) return 'Searching ...';

            if (type === 1)
                var markup = repo.nama;
            else
                var markup = '[' + repo.code + '] ' + repo.name;

            return markup;
        },
        templateSelection: function (repo) {
            console.log(repo)
            if (type === 1)
                return repo.text || repo.nama;
            else
                return repo.text || '[' + repo.code + '] ' + repo.name;
        },
        escapeMarkup: function (markup) { return markup; }
    }
}
