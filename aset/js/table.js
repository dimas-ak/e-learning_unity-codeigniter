/*

    DEVELOPED BY : DIMAS AWANG KUSUMA (Arjunane)

*/

(function (factory) {
    if (typeof define === "function" && define.amd) {

        // AMD. Register as an anonymous module.
        define(["jquery", "./version"], factory);
    } else {

        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var click = "click",
        dataJSON  = new Array();
    var no = 1;
    
    $.fn.table = function(obj)
    {
        $(this).each(function () {
            var url = obj.url,
                number = no; // number every each selector

            var ini = $(this);

            if(obj.thead)           tb.getThead(obj.thead);
            if(obj.search)          tb.getTheadSearch(obj.search);
            if(obj.order_by)        tb.order_by(obj.order_by);
            if(obj.action)          tb.getAction(obj.action);
            if(obj.theadFixed)      tb.getTheadFixed(obj.theadFixed);
            if(obj.theadFixedTop)   tb.getTheadFixedTop(obj.theadFixedTop);
            if(obj.array_info)      tb.getArrayInfo(obj.array_info);
            if(obj.hidden_index)    tb.getHiddenIndex(obj.hidden_index);

            ini.html(tb.setTable());

            var container   = ini.find(".arjunane-table"),
                tbody       = ini.find(".a-table tbody"),
                tFixed      = ini.find('.t-fixed'),
                th_fixed    = tFixed.find("th"),
                conf        = ini.find('.conf'),
                conf_body   = conf.find('.inner-conf'),
                btn_ok      = conf.find('.btn-ok'),
                table       = ini.find('.a-table'),
                entry       = ini.find(".table-entry"),
                search      = ini.find(".a-table .search"),
                td          = tbody.find("td"),
                pagination  = container.find(".pagination"),
                th          = ini.find(".a-table thead th");
            $.ajax({
                url : url,
                type: "POST",
                beforeSend: function ()
                {
                    td.html("Please wait a moment...");
                },
                success: function (data) 
                {
                    var json = JSON.parse(data);
                    if(json.length === 0) {td.html("Data are empty.");}
                    else 
                    {
                        dataJSON[number] = json;
                        tb.getAllData(dataJSON[number]);
                        tbody.html(tb.tbody(dataJSON[number]));
                        pagination.html(tb.pagination());
                    }
                    
                },
                error: function ()
                {
                    td.html("Ops!!! Something went wrong, please try again...");
                }
            });

            ini.on(click, 'a.t-del', function (x) {
                x.preventDefault();
                conf.addClass('aktif');
                var width       = $(window).innerWidth(),
                    height      = $(window).innerHeight(),
                    conf_height = conf_body.outerHeight(),
                    conf_width  = conf_body.outerWidth();
                btn_ok.attr('url', $(this).attr('href'));
                conf_body.css({top: (height / 2) - (conf_height / 2), left: (width / 2) - (conf_width / 2)});
            });

            ini.on(click, '.close', function () { conf.removeClass('aktif'); });

            btn_ok.on(click, function () { window.location.href = $(this).attr('url'); });

            ini.on(click, '.a-table th, .t-fixed th', function() {
                var ini = $(this),
                    parent = ini.parent();
                if(ini.attr('sort') !== 'action' && !parent.hasClass('search'))
                {
                    tbody.html(tb.changeSort(ini.index(), ini.attr('sort')));
                    pagination.html(tb.pagination());
                    if(ini.attr('sort') === 'asc') {ini.attr('sort','desc');ini.removeClass('desc');ini.addClass("asc");}
                    else                           {ini.attr('sort','asc');ini.removeClass('asc');ini.addClass("desc");}
                }
            });

            search.on("keyup", "input", function () {
                var ini   = $(this),
                    val   = ini.val(),
                    index = ini.parent().index() - 1;
                var data  = tb.onInput(index, val);
                tbody.html(data[0]);
                pagination.html(data[1]);
                
            });

            ini.on({
                mouseenter: function ()
                {
                    var ini   = $(this),
                        index = ini.index(),
                        parent = ini.parent(),
                        tr    = tbody.find("tr");
                    if(!parent.hasClass('search'))
                    {
                        for(var i = 0; i < tr.length; i++)
                        {
                            tr.eq(i).find("td").eq(index).addClass("hover");
                        }
                    }
                    
                },
                mouseleave: function ()
                {
                    var ini   = $(this),
                        index = ini.index(),
                        tr    = tbody.find("tr");
                    for(var i = 0; i < tr.length; i++)
                    {
                        tr.eq(i).find("td").eq(index).removeClass("hover");
                    }
                }
            }, '.a-table th, .t-fixed th');

            $(document).scroll(function () {
                var table_top  = table.offset().top,
                    table_left = table.offset().left,
                    scrollTop     = $(this).scrollTop(),
                    top           = tb.setTheadFixedTop(),
                    scrollLeft    = $(this).scrollLeft();
                // jika scroll melebihi thead normal
                (scrollTop > table_top) ? tFixed.addClass('aktif') : tFixed.removeClass('aktif');
                
                for(var i = 0; i < th.length; i++)
                {
                    var width = th.eq(i).outerWidth(),
                        width_table = table.outerWidth();
                    tFixed.css("width", width_table + "px");
                    th_fixed.eq(i).css("width", width + "px");
                }
                (scrollLeft > 0) ? tFixed.css({left: (table_left - scrollLeft)}) : tFixed.css("left", table_left + "px");
                tFixed.css({top: top + "px"});
                var ini_height = ini.outerHeight() + ini.offset().top;
                // jika scroll melebihi content table
                if(ini_height < table_top) tFixed.removeClass('aktif');
                
            });

            th.on('change', 'select', function () {
                var ini   = $(this),
                    val   = ini.val(),
                    index = ini.parent().index() - 1;
                
                var data  = tb.onInput(index, val);
                tbody.html(data[0]);
                pagination.html(data[1]);
            });

            entry.on("change", function() {                
                var ini     = $(this),
                    data    = tb.changeRows(ini.val()),
                    _tbody  = data[0],
                    pg      = data[1];
                tbody.html(_tbody);
                pagination.html(pg);
            });

            pagination.on(click, '.page ', function() {
                var ini = $(this);
                if(!ini.hasClass('aktif') && !ini.hasClass('n-a'))
                {
                    pagination.html(tb.pagination(ini.attr('index-page')));
                    tbody.html(tb.changePage());
                }
            });

            no++;
        });
    }

    var table = function() 
    {
        this.maxEntry       = 10; // default data of rows
        this.startEntry     = 0;
        this.dt_order_by    = [0, 'asc'];
        this.theadSearch    = null;
        this.time_load      = new Date().getTime();
        this.dt_thead       = null;
        this.midle_page     = 4;
        this.dt_theadFixedTop=0;
        this.order_last     = false;
        this.dt_all         = null;
        this.dt_search      = null;
        this.array_info     = null;
        this.sort_search    = new Array();
        this.val_search     = {};
        this.index_page     = 1;
        this.action         = null;
        this.theadFixed     = false;
        this.hidden_index   = new Array();
    };


    table.prototype.setTable = function ()
    {
        var elem = '<div class="arjunane-table">' +
                        this.btnEntry() +
                        this.setConfirm() +
                        this.setTheadFixed() +
                        "<table class='a-table'>" +
                            this.thead() + 
                            this.tbody() +
                        "</table>" +
                        '<div class="pagination"></div>' +
                    "</div>";
        return elem;
    }

    table.prototype.setTheadFixed = function ()
    {
        var elem = "";
        if(this.theadFixed)
        {
            var thead = this.dt_thead,
                order_by = this.dt_order_by;
            elem += "<table class='t-fixed'><thead>";
            elem += "<tr><th sort='desc' class=\"asc\"><span>No</span></th>";
            for(var i = 0; i < thead.length; i++)
            {
                if(!this.isHidden(i))
                {
                    attr = (i === order_by[0]) ? (order_by[1].toString().toLowerCase() === "desc") ? "desc" : "asc" : 'asc';
                    elem += "<th sort=\"" + attr + "\" class=\"" + attr+ "\"><span>" + thead[i] + "</span></th>";
                }
            }
            if(this.action !== null)
            {
                elem += '<th class="action" sort="action">Action</th>';
            }
            elem += "</tr></table>";
        }
        return elem;
    };

    table.prototype.setConfirm = function ()
    {
        var elem  = "";
        if(this.action.del)
        {
            var del   = this.action.del,
            field = (typeof del.field !== 'undefined') ? this.dt_thead[del.field] : this.dt_thead[del.id],
            msg   = del.msg.toString().replace("%s", field);
            elem += '<div class="conf">' + 
                        '<div class="inner-conf">' +
                            '<div class="conf-head">' +
                                'Confirm' +
                                '<div class="close-conf close"></div>' +
                            '</div>'+
                            '<div class="conf-info">' + msg + '</div>' +
                            '<div class="conf-button"><button url="" class="btn-ok">OK</button><button class="close">Cancel</button></div>' +
                        '</div>' +
                    "</div>";
        }
        return elem;
    }

    table.prototype.btnEntry = function()
    {
        var arr = [10, 25, 50, 100, 250, 500],
            elem = '<span>Number of rows </span><select class="table-entry">';
            for(var i = 0; i < arr.length; i++)
            {
                elem += '<option val="' + arr[i] + '">' + arr[i] + '</option>';
            }
            elem += '</select>';
        return elem;
    };

    // element thead
    table.prototype.thead = function ()
    {
        var thead       = this.dt_thead, // mendapatkan data string array thead
            elem        = "",
            theadSearch = this.theadSearch,
            val_search  = this.val_search,
            order_by    = this.dt_order_by, // mendapatkan penyortiran (asc || desc)
            attr        = "";
        elem += "<thead>";
        elem += "<tr><th sort='desc' class=\"asc\"><span>No</span></th>";
        for(var i = 0; i < thead.length; i++)
        {
            if(!this.isHidden(i))
            {
                attr = (i === order_by[0]) ? (order_by[1].toString().toLowerCase() === "desc") ? "desc" : "asc" : 'asc';
                elem += "<th sort=\"" + attr + "\" class=\"" + attr+ "\"><span>" + thead[i] + "</span></th>";
            }
        }
        if(this.action !== null)
        {
            elem += '<th class="action" sort="action">Action</th>';
        }
        
        elem += "</tr>";
        if(theadSearch !== null)
        {
            elem += '<tr class="search">';
            elem += '<th></th>';
            for(var t = 0 ; t < thead.length; t++)
            {
                if(!this.isHidden(t))
                {
                    var exists = false;
                    for(var ts = 0; ts < theadSearch.length; ts++)
                    {
                        var tSearch = theadSearch[ts],
                            type = tSearch.type;
                        if(tSearch.index === t)
                        {
                            exists = true;
                            elem += '<th>';
                            if(type === 'input')
                            {
                                elem += '<input placeholder="' + tSearch.placeholder + '">';
                            }
                            else if(type === 'select')
                            {
                                elem += '<select>';
                                    for(var sel = 0; sel < tSearch.value.length; sel++)
                                    {
                                        elem += '<option value="' + tSearch.value[sel][0] + '">' + tSearch.value[sel][1] + '</option>';
                                    }
                                elem += '</select>';
                            }
                            elem += '</th>';
                            val_search[t] = false; 
                        }
                    }
                    if(!exists) {elem += '<th></th>';}
                }
                
            }
            if(this.action !== null)
            {
                elem += '<th></th>';
            }
            elem += '</tr>';
        }
        elem += "</thead>";
        return elem;
    };

    // element tbody
    table.prototype.tbody = function (data)
    {
        var elem = "";
        // ketika pertama kali tbody di append
        if(typeof data === 'undefined')
        {
            elem += "<tbody><tr><td colspan=\"" + this.dt_thead.length + 1 + "\"></td></tr></tbody>";
        }
        else
        {
            var sort = this.sortData();
            for(var i = this.startEntry; i < this.maxEntry; i++)
            {
                elem += this.setTD(sort, i);
            }
            
        }
        return elem;
    };

    table.prototype.changeSort = function(index, attr)
    {
        var elem     = "",
            dt_ajax  = (this.dt_search === null) ? this.dt_all : this.dt_search;
        this.index_page = 1;
        // jika th yang terklik adalah index 0 / number
        if(index === 0)
        {
            var max = dt_ajax.length - this.maxEntry;
            if(attr === 'desc')
            {
                for(var i = (dt_ajax.length - 1); max < i; i--)
                {
                    elem += this.setTD(dt_ajax, i);
                }
                // set index_page if order number is last
                this.index_page = Math.ceil(dt_ajax.length / this.maxEntry);
            }
            else
            {
                for(var i = 0; i < this.maxEntry; i++)
                {
                    elem += this.setTD(dt_ajax, i);
                }
                // set index_page if order number is first
                this.index_page = 1;
            }
        }
        else
        {
            var isDate = this.isDate;
            index = this.normalizeHiddenIndex(index - 1);
            dt_ajax.sort(function (a, b) {
                var ind  = index,
                    dt_1 = (isDate(a[ind])) ? new Date(a[ind]) : a[ind],
                    dt_2 = (isDate(b[ind])) ? new Date(b[ind]) : b[ind];
                if( ( isDate(a[ind]) && isDate(b[ind]) ) || ( !isNaN(a[ind]) && !isNaN(b[ind]) ) )
                {
                    return (attr === 'desc') ? dt_2 - dt_1 : dt_1 - dt_2;
                }
                else
                {
                    if (a[ind] < b[ind] || a[ind] > b[ind]) {return -1; }
                    return 0;
                }
            });
            for(var i = this.startEntry; i < this.maxEntry; i++)
            {
                
                elem += this.setTD(dt_ajax, i);
            }
            // set all data where thead is clicked
            if(this.dt_search === null)
            {
                this.dt_all = dt_ajax;
            }
            else
            {
                this.dt_search = dt_ajax;
            }
            // set index_page if order number is first
            this.index_page = 1;
        }
        
        return elem;
    };

    table.prototype.setTD     = function (dt_ajax, i)
    {
        var elem       = "",
            array_info = this.array_info;
            
        if(i < dt_ajax.length && i >= 0) 
        {
            elem += "<tr>";
            elem += "<td>" + (i + 1) + ".</td>";
            var dt        = dt_ajax[i],
                data_ajax = this.dataToArray(dt);
    
            for(var td = 0; td < data_ajax.length; td++)
            {
                if(!this.isHidden(td))
                {
                    var name = data_ajax[td];
                    if(array_info !== null)
                    {
                        if(array_info.index === td)
                        {
                            name = array_info.value[data_ajax[td]];
                        }
                    }
                    elem += "<td>" + name + "</td>";
                }
            }
    
            elem += this.setAction(data_ajax);
            elem += "</tr>";
        }
        
        return elem;
    };

    table.prototype.setAction = function (data)
    {
        var elem = "";
        if(this.action !== null)
        {
            var action = this.action;
            elem += "<td class='action'>";
            if(action.edit)
            {
                var edit = action.edit;
                var text = edit.text ? edit.text : "EDIT";
                elem += '<a class="t-edit" href="' + edit.url + data[edit.id] + '">' + text + '</a>';
            }
            if(action.del)
            {
                var del   = action.del;
                elem += '<a class="t-del" href="' + del.url + data[del.id] + '">DELETE</a>';
            }
            elem += "</td>";
        }
        return elem;
    }

    table.prototype.changeRows = function (val) 
    {
        this.index_page = 1;
        this.maxEntry   = parseInt(val);

        var index    = this.index_page,
            maxEntry = this.maxEntry,
            elem     = [],
            data     = (this.dt_search === null) ? this.dt_all : this.dt_search,
            tbody    = "";
            
        for(var i = (index - 1); i < maxEntry; i++)
        {
            tbody  += this.setTD(data, i);
        }

        elem[0] = tbody;
        elem[1] = this.pagination();

        return elem;
        
    };

    table.prototype.changePage = function ()
    {
        var index    = (this.index_page === 1) ? 0 : (this.index_page - 1) * this.maxEntry,
            maxEntry = this.maxEntry * this.index_page,
            data     = (this.dt_search === null) ? this.dt_all : this.dt_search,
            elem     = "";
        for(var i = index; i < maxEntry; i++)
        {
            elem  += this.setTD(data, i);
        }
        return elem;
    };

    // order_by yang aktif
    table.prototype.order_by = function (data)
    {
        this.dt_order_by = data;
        return this;
    };

    // thead bagian pencarian (jika ada)
    table.prototype.getTheadSearch = function (theadSearch)
    {
        this.theadSearch = theadSearch;
        return this;
    };

    table.prototype.onInput = function (index, value)
    {
        var data       = this.dt_all,
            elem       = [],
            sort_search=this.sort_search,
            tbody      = "";

        this.index_page = 1;
        index = this.normalizeHiddenIndex(index);
        
        if(sort_search.indexOf(index) === -1) sort_search.push(index);
        else if(value.length === 0 && sort_search.indexOf(index) !== -1) sort_search.splice(sort_search.indexOf(index), 1);

        this.val_search[index] = (value.length !== 0) ? value.toString() : false;

        if(sort_search.length > 0)
        {
            this.dt_search = [];
            for(var i = 0; i < data.length; i++)
            {
                var dt     = data[i],
                    result = true;
                for(var s = 0; s < sort_search.length; s++)
                {
                    var sort= sort_search[s],
                        val = this.val_search[sort],
                        str = String(dt[sort]).match(new RegExp(val, "gi"));

                    if(str === null) result = false;
                }
                
                if(result)
                {
                    this.dt_search.push(dt);
                }
            }
        }
        
        if(this.isValuesNull()) this.dt_search = null;
         
        if(this.dt_search !== null)
        {
            for(var i = 0; i < this.maxEntry; i++)
            {
                tbody += this.setTD(this.dt_search, i);
            }
        }
        else
        {
            for(var i = 0; i < this.maxEntry; i++)
            {
                tbody += this.setTD(data, i);
            }
        }

        elem[0] = tbody;
        elem[1] = this.pagination();

        return elem;
    };

    table.prototype.isValuesNull = function ()
    {
        var val = this.val_search;
        for(var v in val)
        {
          if(typeof val[v] === 'string') return false;
        }
        
      return true;
    };

    table.prototype.normalizeHiddenIndex = function (index) 
    {
        var ind  = index,
            plus = 0;
        if(this.hidden_index.length > 0)
        {
            for(var i = 0; i < this.dt_thead.length; i++)
            {
                for(var hid = 0; hid < this.hidden_index.length; hid++)
                {
                    if(i === hid)
                    { 
                        plus += 1;
                        ind = index + plus;
                    }
                }
            }
        }
        return ind;
    };

    table.prototype.pagination = function(val)
    {
        if(typeof val !== 'undefined')
        { 
            this.index_page = parseInt(val);
        } 
        var data            = (this.dt_search === null) ? this.dt_all : this.dt_search,
            elem            = "",
            middle_page     = this.midle_page,
            index           = this.index_page,
            cls             = "",
            load            = "",
            maxEntry        = this.maxEntry * index,
            start_index     = (index <= middle_page) ? 1 : index,
            show            = (index === 1) ? 1 : (index - 1) * this.maxEntry, // index halaman
            // jumlah halaman dimana index halaman di kali jumlah entry data yang akan di tampilkan
            show_to         = 0, 
            last_page       = Math.ceil(data.length / this.maxEntry), // membulatkan pembagian
            last_index_plus = (index <= middle_page) ? 1 + middle_page : index + middle_page,
            last_index_min  = last_page - middle_page,
            previous        = (index !== 1) ? index - 1 : 1,
            cls_previous    = (index === 1) ? " aktif" : "",
            next            = (index !== last_page) ? index + 1 : last_page,
            cls_next        = (index === last_page) ? " aktif" : "";

        cls         = (index === 1) ? " aktif" : ""; 
        
        // mendapatkan jumlah pada halaman peratma
        if(index === 1)                 show_to = this.maxEntry;
        // jika jumlah data lebih kecil dari maxEntry
        else if(maxEntry > data.length) show_to = maxEntry - ( maxEntry - data.length );
        else                            show_to = index * this.maxEntry;

        if(this.time_load !== null) load = '  (Results took ' + ((new Date().getTime() - this.time_load) / 1000).toFixed(4) + " seconds.)";

        // info load data dari data ke- sampai data ke-
        elem += '<div class="i-page">Showing ' + show + ' to ' + show_to + ' of ' + data.length + load + '</div>';

        elem += '<div class="page' + cls_previous + '" index-page="' + previous + '">Previous</div>';

        // jika index_page lebih dari middle_page (halaman tengah)
        if((index > middle_page && index !== last_page) || (index > middle_page && index === last_page)) 
        {
            elem += '<div class="page" index-page="1">1</div>'
            elem += '<div class="page n-a">...</div>';
        }

        if(index > (middle_page + 1)) start_index = index - 1;

        // jika halaman yang di tuju hampir halaman terakhir (dimana index_page di tambah dengan middle_page)
        if((index + middle_page) >= last_page) 
        {
            last_index_plus = last_page;
            start_index     = last_page - middle_page;
        }
        
        // jika hasil pengurangan start_index hasil nya lebih kecil dari 0 maka akan di set ke 1
        if(start_index <= 0) start_index = 1;

        for(var i = start_index; i <= last_index_plus; i++)
        {
            cls = (index === i) ? " aktif" : "";
            elem += '<div index-page="' + i + '" class="page' + cls + '">' + i + '</div>';
        }

        if(index < last_index_min) 
        {
            elem += '<div class="page n-a">...</div>';
            elem += '<div class="page" index-page="' + last_page + '">' + last_page + '</div>'
        }
        elem += '<div class="page' + cls_next + '" index-page="' + next + '">Next</div>';

        // jika data kosong
        if(data.length === 0) elem = "";
        
        // set waktu ke null supaya tidak ada kalkulasi waktu lagi
        this.time_load = null;
        return elem;
    }

    table.prototype.setTheadFixedTop = function ()
    {
        return this.dt_theadFixedTop;
    };

    table.prototype.sortData = function () 
    {
        var dt_order = this.dt_order_by,
            index    = dt_order[0],
            order    = (typeof dt_order[1] !== 'undefined') ? dt_order[1].toString().toLowerCase() : "asc",
            dt_ajax  = this.dt_all;
            
        dt_ajax.sort(function (a, b) {
            return (order === 'desc') ? b[index] - a[index] : a[index] - b[index];
        });
        this.dt_all = dt_ajax;
        return dt_ajax;
    };

    table.prototype.isDate = function(val)
    {
        var result = false;
        if(isNaN(val))
        {
            var dt = new Date(val);
            if(!isNaN(dt.getTime()))
            {
                result = true;
            }
        }
        
        return result;
    };

    table.prototype.isTheadFixed = function ()
    {
        return this.theadFixed;
    }

    table.prototype.getArrayInfo = function (data)
    {
        this.array_info = data;
        return this;
    };

    table.prototype.getTheadFixed = function (data)
    {
        this.theadFixed = data;
        return this;
    };

    table.prototype.getHiddenIndex = function (data) 
    {
        this.hidden_index = data;
        return this;
    };

    table.prototype.getTheadFixedTop = function (data) 
    {
        this.dt_theadFixedTop = data;
        return this;
    };


    // mendapatkan aksi button
    table.prototype.getAction  = function (data)
    {
        this.action            = data;
        return this;
    };
    // mendapatkan data hasil ajax
    table.prototype.getAllData  = function(data)
    {
        this.dt_all = data;
        return this;
    };

    table.prototype.isHidden = function (td) 
    {
        var hidden = this.hidden_index;
        return (hidden.indexOf(td) !== -1) ? true : false;
    };

    // mengubah value setiap object ke bentuk array
    table.prototype.dataToArray     = function (obj)
    {
        var arr = new Array();
        for (key in obj) {
            if (obj.hasOwnProperty(key)) arr.push(obj[key]);
        }
        return arr;
    };

    // mendapatkan  namasetiap thead
    table.prototype.getThead = function (thead)
    {
        this.dt_thead = thead;
        return this;
    };
    var tb = new table();
}));