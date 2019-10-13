(function () {
    var app = angular.module('cv-arie', []);

    app.controller("SearchItemCtrl", ['$scope', '$http', function ($scope, $http) {
        $scope.produks = [];
        $http.get('api/produk').success(function (data) {
            $scope.produks = data;
        });
        $scope.produktemp = [];
        $scope.newproduktemp = {};
        $http.get('api/produktemp').success(function (data, status, headers, config) {
            $scope.produktemp = data;
        });
        $scope.addProdukTemp = function (produk, newproduktemp) {
            $http.post('api/produktemp', { id_produk: 
                produk.id, nama: produk.nama, bahan_baku: produk.id_bahanbaku, ukuran: produk.id_ukuran, harga: produk.harga }).
                success(function (data, status, headers, config) {
                    $scope.produktemp.push(data);
                    $http.get('api/produktemp').success(function (data) {
                        $scope.produktemp = data;
                    });
                });
        }
        $scope.updateSaleTemp = function (newproduktemp) {
            $http.put('api/produktemp/' + newproduktemp.id, { id_produk: newproduktemp.id, quantity: newproduktemp.jumlah, primary : newproduktemp.id_produk, sisi_cetak: newproduktemp.sisi_cetak }).
                success(function (data, status, headers, config) {

                    $http.get('api/produktemp').success(function (data) {
                        $scope.produktemp = data;
                        console.log(data)
                    });
                });
                
                console.log('updated')
          


        }

        $scope.doSearch = function (id) {
            $http.delete('api/produktemp/' + id).
                success(function (data, status, headers, config) {
                    $http.get('api/produktemp').success(function (data) {
                        $scope.produktemp = data;
                    });
                });
        }

        $scope.removeSaleTemp = function (id) {
            $http.delete('api/produktemp/' + id).
                success(function (data, status, headers, config) {
                    $http.get('api/produktemp').success(function (data) {
                        $scope.produktemp = data;
                    });
                });
        }
        $scope.sum = function (list) {
            var total = 0;
            angular.forEach(list, function (newproduktemp) {
                total += parseFloat(newproduktemp.harga * newproduktemp.jumlah);
            });
            return total;
        }

    }]);
})();
