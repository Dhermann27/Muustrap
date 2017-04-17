/**
 * Filter a column on a specific date range. Note that you will likely need
 * to change the id's on the inputs and the columns in which the start and
 * end date exist.
 *
 *  @name Date range filter
 *  @summary Filter the table based on two dates in different columns
 *  @author _guillimon_
 *
 *  @example
 *    $(document).ready(function() {
 *        var table = $('#example').DataTable();
 *
 *        // Add event listeners to the two range filtering inputs
 *        $('#min').keyup( function() { table.draw(); } );
 *        $('#max').keyup( function() { table.draw(); } );
 *    } );
 */

$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
        var iFini = document.getElementById('fini').value.replace(/-/g, "");
        var iFfin = document.getElementById('ffin').value.replace(/-/g, "");
        var iStartDateCol = 4;
        var iEndDateCol = 4;

        var datofini=aData[iStartDateCol].replace(/-/g, "");
        var datoffin=aData[iEndDateCol].replace(/-/g, "");

        if ( iFini === "" && iFfin === "" )
        {
            return true;
        }
        else if ( iFini <= datofini && iFfin === "")
        {
            return true;
        }
        else if ( iFfin >= datoffin && iFini === "")
        {
            return true;
        }
        else if (iFini <= datofini && iFfin >= datoffin)
        {
            return true;
        }
        return false;
    }
);