<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->


        <!-- search form (Optional) -->

        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Menu</li>
            {{-- <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Transaksi</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('daftar-transaksi')}}"><i class='fa  fa-list'></i> <span>Daftar Transaksi</span></a></li>
                    <li><a href="{{url('gudang/createKeluar')}}"><i class='fa fa-arrow-right'></i> <span>Penjualan</span></a></li>
                    <li><a href="{{route('gudang.create')}}"><i class='fa  fa-arrow-left'></i> <span>Pembelian</span></a></li>
                </ul>
            </li> --}}
            <li @yield('stock-treeview')>
                <a href="#"><i class='fa fa-link'></i> <span>Stock</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li @yield('items')><a href="{{route('items.index')}}"><i class='fa fa-cubes'></i> <span>Item</span></a></li>
                    <li @yield('stock')><a href="{{route('stock.index')}}"><i class='fa fa-cubes'></i> <span>Stock</span></a></li>
                </ul>
            </li>
            <li @yield('items-treeview')>
                <a href="#"><i class='fa fa-link'></i> <span>Menus</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li @yield('category')><a href="{{route('category.index')}}"><i class='fa fa-cubes'></i> <span>Category</span></a></li>
                    <li @yield('menu')><a href="{{route('menu.index')}}"><i class='fa fa-cubes'></i> <span>Menu</span></a></li>
                </ul>
            </li>
            {{-- <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Akuntansi</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <!-- <li><a href="{{route('transactions.create')}}"><i class='fa fa-credit-card'></i> <span>Buat Jurnal</span></a></li> -->
                    <li><a href="{{route('bank.index')}}"><i class='fa fa-money'></i> <span>Kas</span></a></li>
                    <li><a href="{{url('daftarGiro')}}"><i class='fa fa-money'></i> <span>Daftar Giro</span></a></li>
                    <li><a href="{{url('hutang')}}"><i class='fa fa-minus-square'></i> <span>Hutang</span></a></li>
                    <li><a href="{{url('piutang')}}"><i class='fa fa-credit-card'></i> <span>Piutang</span></a></li>
                    <li><a href="{{url('biaya')}}"><i class='fa fa-credit-card'></i> <span>Biaya</span></a></li>
                    <li><a href="{{url('penjualan')}}"><i class='fa fa-credit-card'></i> <span>Daftar Penjualan</span></a></li>
                    <li><a href="{{url('pembelian')}}"><i class='fa fa-credit-card'></i> <span>Daftar Pembelian</span></a></li>

                </ul>
            </li> --}}
           {{--  <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Karyawan</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('karyawan.index')}}"><i class='fa fa-credit-card'></i> <span>Data Karyawan</span></a></li>
                    <li><a href="{{url('kegiatan')}}"><i class='fa fa-credit-card'></i> <span>Absensi Karyawan</span></a></li>
                    <li>
                      <a href="#"><i class="fa fa-credit-card"></i> Sum Absen <i class="fa fa-angle-left pull-right"></i></a>
                      <ul class="treeview-menu">
                        <li><a href="{{url('sumAbsen')}}"><i class="fa fa-circle-o"></i> Bulanan</a></li>
                        <li><a href="{{url('sum-absen-mingguan')}}"><i class="fa fa-circle-o"></i> Mingguan</a></li>
                      </ul>
                    </li>
                    <li><a href="{{url('kasbon')}}"><i class='fa fa-credit-card'></i> <span>Kasbon Karyawan</span></a></li>
                    <li><a href="{{url('gaji')}}"><i class='fa fa-credit-card'></i> <span>Gaji </span></a></li>
                    <li><a href="{{url('generate-gaji')}}"><i class='fa fa-credit-card'></i> <span>Generate Gaji </span></a></li>
                </ul>
            </li> --}}
            {{--  <li class="treeview">
                <a href="#"><i class='fa fa-download'></i> <span>Unduh Data Mentah</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('rawPenjualan')}}"><i class='fa fa-download'></i> <span>Penjualan</span></a></li>
                    <li><a href="{{url('rawPembelian')}}"><i class='fa fa-download'></i> <span>Pembelian</span></a></li>
                </ul>
            </li> --}}

            {{-- <li><a href="{{route('partner.index')}}"><i class='fa  fa-users'></i> <span>Partner</span></a></li> --}}
            {{-- <li><a href="{{url('tutupBuku')}}"><i class='fa  fa-book'></i> <span>Tutup Buku</span></a></li> --}}
            {{-- <li><a href="{{route('stock.index')}}"><i class='fa fa-building'></i> <span>Stock Management</span></a></li> --}}
            <li @yield('table-tree-link')>
                <a href="#"><i class='fa fa-link'></i> <span>Table</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li @yield('area-link')><a href="{{route('area.index')}}"><i class='fa fa-users'></i> <span>Area</span></a></li>
                    <li @yield('table-link')><a href="{{route('table.index')}}"><i class='fa fa-users'></i> <span>Table</span></a></li>
                </ul>
            </li>
            <li @yield('account-tree-link')>
                <a href="#"><i class='fa fa-link'></i> <span>Accounting</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li @yield('account-link')><a href="{{route('account.index')}}"><i class='fa fa-users'></i> <span>Account</span></a></li>
                    <li @yield('jurnal-link')><a href="{{route('transaction.index')}}"><i class='fa fa-users'></i> <span>Journal</span></a></li>
                </ul>
            </li>
            <li @yield('member-tree-link')>
                <a href="#"><i class='fa fa-link'></i> <span>Member</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li @yield('employee-link')><a href="{{route('member.index')}}"><i class='fa fa-users'></i> <span>Member</span></a></li>
                    <li @yield('piutang-link')><a href="{{url('piutang-karyawan')}}"><i class='fa fa-users'></i> <span>Piutang Member</span></a></li>
                </ul>
            </li>            
            <li @yield('bank')><a href="{{route('bank.index')}}"><i class='fa fa-dollar'></i> <span>Mesin EDC</span></a></li>
            <li @yield('laporan-tree-link')>
            <a href="#"><i class='fa fa-book'></i> <span>Laporan Keuangan</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    
                    <li @yield('r-trans')><a href="{{url('r-trans')}}"><i class='fa fa-book'></i> <span>Laporan Transaksi</span></a></li>
                    <li @yield('penjualan')><a href="{{url('r-menu')}}"><i class='fa fa-book'></i> <span>Laporan Penjualan Menu</span></a></li>
                </ul>
            </li>
            <li @yield('user-mgmt')><a href="{{route('user.index')}}"><i class='fa fa-users'></i> <span>User Management</span></a></li>
            <li @yield('ganti-pass')><a href="{{url('gantiPassword')}}"><i class='fa  fa-lock'></i> <span>Ganti Password</span></a></li>
            <li><a href="{{url('auth/logout')}}"><i class='fa  fa-sign-out'></i> <span>Logout</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
