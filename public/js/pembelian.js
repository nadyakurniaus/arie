(function(){
    var app = angular.module('cv-arie', [ ]);

    app.controller("SearchItemCtrl", [ '$scope', '$http', function($scope, $http) {
        $scope.produks = [ ];
        $http.get('api/produk').success(function(data) {
            $scope.produks = data;
        });
        $scope.produktemp = [ ];
        $scope.newproduktemp = { };
        $http.get('api/pembeliantemp').success(function(data, status, headers, config) {
            $scope.produktemp = data;
        });
        $scope.addProdukTemp = function(item, newproduktemp) {
            $http.post('api/pembeliantemp', { id_produk: item.id, nama: item.nama, bahan_baku: item.bahan_baku, ukuran: item.ukuran, harga: item.harga }).
            success(function(data, status, headers, config) {
                $scope.produktemp.push(data);
                    $http.get('api/pembeliantemp').success(function(data) {
                    $scope.produktemp = data;
                    });
            });
        }
        $scope.updateSaleTemp = function(newproduktemp) {
            
            $http.put('api/pembeliantemp/' + newproduktemp.id, { quantity: newproduktemp.quantity, total_cost: newproduktemp.harga * newproduktemp.quantity,
                total_selling: newproduktemp.harga * newproduktemp.quantity }).
            success(function(data, status, headers, config) {
                
                });
        }
        $scope.removeSaleTemp = function(id) {
            $http.delete('api/pembeliantemp/' + id).
            success(function(data, status, headers, config) {
                $http.get('api/pembeliantemp').success(function(data) {
                        $scope.produktemp = data;
                        });
                });
        }
        $scope.sum = function(list) {
            var total=0;
            angular.forEach(list , function(newproduktemp){
                total+= parseFloat(newproduktemp.harga * newproduktemp.jumlah);
            });
            return total;
        }

    }]);
})();