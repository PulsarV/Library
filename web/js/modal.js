$(function(){var t=$("body"),a=t.find("table").attr("data-entity");function n(t){t.modal("show")}$(".add-button").on("click",function(){var t=$(this).attr("data-rname");$.ajax({url:Routing.generate(t),method:"GET",dataType:"html"}).done(function(t){n($(t))})}),$(".edit-button").on("click",function(){var t=$(this).attr("data-rname"),e=$(this).attr("data-id"),o={};o[a]=e,$.ajax({url:Routing.generate(t,o),method:"GET",dataType:"html"}).done(function(t){n($(t))})}),$(".delete-button").on("click",function(){var t=$(this).attr("data-rname"),e=$(this).attr("data-id"),o={};o[a]=e,$.ajax({url:Routing.generate(t,o),method:"GET",dataType:"html"}).done(function(t){n($(t))})}),t.on("shown.bs.modal",function(t){var a=$(this).find("#app_bundle_book_type_tags");$(a).chosen({search_contains:!0,placeholder_text_multiple:"  Select tags"});var e=$(t.target);e.find("form").on("submit",function(t){t.preventDefault(),event.preventDefault();var a=$(this);$.ajax({type:a.attr("method"),url:a.attr("action"),data:a.serialize(),dataType:"html"}).done(function(t){e.modal("hide"),"SUCCESS"===t?location.reload():n($(t))})})}),t.on("hidden.bs.modal",".modal",function(){$(this).removeData("bs.modal"),$(this).remove()})});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm1vZGFsLmpzIl0sIm5hbWVzIjpbIiQiLCJib2R5IiwiZW50aXR5IiwiZmluZCIsImF0dHIiLCJzaG93TW9kYWxXaW5kb3ciLCJtb2RhbCIsIm9uIiwicm91dGUiLCJ0aGlzIiwiYWpheCIsInVybCIsIlJvdXRpbmciLCJnZW5lcmF0ZSIsIm1ldGhvZCIsImRhdGFUeXBlIiwiZG9uZSIsImRhdGEiLCJpZCIsInBhcmFtcyIsImUiLCJ0YWdTZWxlY3RvciIsImNob3NlbiIsInNlYXJjaF9jb250YWlucyIsInBsYWNlaG9sZGVyX3RleHRfbXVsdGlwbGUiLCJ0YXJnZXQiLCJwcmV2ZW50RGVmYXVsdCIsImV2ZW50IiwiZm9ybSIsInR5cGUiLCJzZXJpYWxpemUiLCJsb2NhdGlvbiIsInJlbG9hZCIsInJlbW92ZURhdGEiLCJyZW1vdmUiXSwibWFwcGluZ3MiOiJBQUFBQSxFQUFFLFdBQ0EsSUFBSUMsRUFBT0QsRUFBRSxRQUNURSxFQUFTRCxFQUFLRSxLQUFLLFNBQVNDLEtBQUssZUFpRnJDLFNBQVNDLEVBQWdCQyxHQUN2QkEsRUFBTUEsTUFBTSxRQWhGZE4sRUFBRSxlQUFlTyxHQUFHLFFBQVMsV0FDM0IsSUFBSUMsRUFBUVIsRUFBRVMsTUFBTUwsS0FBSyxjQUN6QkosRUFBRVUsTUFDQUMsSUFBS0MsUUFBUUMsU0FBU0wsR0FDdEJNLE9BQVEsTUFDUkMsU0FBVSxTQUVYQyxLQUFLLFNBQVNDLEdBQ2JaLEVBQWdCTCxFQUFFaUIsUUFJdEJqQixFQUFFLGdCQUFnQk8sR0FBRyxRQUFTLFdBQzVCLElBQUlDLEVBQVFSLEVBQUVTLE1BQU1MLEtBQUssY0FDckJjLEVBQUtsQixFQUFFUyxNQUFNTCxLQUFLLFdBQ2xCZSxLQUNKQSxFQUFPakIsR0FBVWdCLEVBRWpCbEIsRUFBRVUsTUFDQUMsSUFBS0MsUUFBUUMsU0FBU0wsRUFBT1csR0FDN0JMLE9BQVEsTUFDUkMsU0FBVSxTQUVYQyxLQUFLLFNBQVNDLEdBQ2JaLEVBQWdCTCxFQUFFaUIsUUFJdEJqQixFQUFFLGtCQUFrQk8sR0FBRyxRQUFTLFdBQzlCLElBQUlDLEVBQVFSLEVBQUVTLE1BQU1MLEtBQUssY0FDckJjLEVBQUtsQixFQUFFUyxNQUFNTCxLQUFLLFdBQ2xCZSxLQUNKQSxFQUFPakIsR0FBVWdCLEVBRWpCbEIsRUFBRVUsTUFDQUMsSUFBS0MsUUFBUUMsU0FBU0wsRUFBT1csR0FDN0JMLE9BQVEsTUFDUkMsU0FBVSxTQUVYQyxLQUFLLFNBQVNDLEdBQ2JaLEVBQWdCTCxFQUFFaUIsUUFJdEJoQixFQUFLTSxHQUFHLGlCQUFrQixTQUFVYSxHQUNsQyxJQUFJQyxFQUFjckIsRUFBRVMsTUFBTU4sS0FBSyw4QkFDL0JILEVBQUVxQixHQUFhQyxRQUNaQyxpQkFBaUIsRUFDakJDLDBCQUEyQixrQkFHOUIsSUFBSWxCLEVBQVFOLEVBQUVvQixFQUFFSyxRQUVoQm5CLEVBQU1ILEtBQUssUUFBUUksR0FBRyxTQUFVLFNBQVNhLEdBQ3ZDQSxFQUFFTSxpQkFDRkMsTUFBTUQsaUJBQ04sSUFBSUUsRUFBTzVCLEVBQUVTLE1BQ2JULEVBQUVVLE1BQ0FtQixLQUFNRCxFQUFLeEIsS0FBSyxVQUNoQk8sSUFBS2lCLEVBQUt4QixLQUFLLFVBQ2ZhLEtBQU1XLEVBQUtFLFlBQ1hmLFNBQVUsU0FDVEMsS0FBSyxTQUFTQyxHQUNDWCxFQXFCZEEsTUFBTSxRQXBCSyxZQUFUVyxFQUNGYyxTQUFTQyxTQUVUM0IsRUFBZ0JMLEVBQUVpQixVQU8xQmhCLEVBQUtNLEdBQUcsa0JBQW1CLFNBQVUsV0FDbkNQLEVBQUVTLE1BQU13QixXQUFXLFlBQ25CakMsRUFBRVMsTUFBTXlCIiwiZmlsZSI6Im1vZGFsLmpzIiwic291cmNlc0NvbnRlbnQiOlsiJChmdW5jdGlvbigpIHtcbiAgdmFyIGJvZHkgPSAkKCdib2R5Jyk7XG4gIHZhciBlbnRpdHkgPSBib2R5LmZpbmQoJ3RhYmxlJykuYXR0cignZGF0YS1lbnRpdHknKTtcblxuICAkKCcuYWRkLWJ1dHRvbicpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgIHZhciByb3V0ZSA9ICQodGhpcykuYXR0cignZGF0YS1ybmFtZScpO1xuICAgICQuYWpheCh7XG4gICAgICB1cmw6IFJvdXRpbmcuZ2VuZXJhdGUocm91dGUpLFxuICAgICAgbWV0aG9kOiAnR0VUJyxcbiAgICAgIGRhdGFUeXBlOiAnaHRtbCdcbiAgICB9KVxuICAgIC5kb25lKGZ1bmN0aW9uKGRhdGEpIHtcbiAgICAgIHNob3dNb2RhbFdpbmRvdygkKGRhdGEpKTtcbiAgICB9KTtcbiAgfSk7XG5cbiAgJCgnLmVkaXQtYnV0dG9uJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XG4gICAgdmFyIHJvdXRlID0gJCh0aGlzKS5hdHRyKCdkYXRhLXJuYW1lJyk7XG4gICAgdmFyIGlkID0gJCh0aGlzKS5hdHRyKCdkYXRhLWlkJyk7XG4gICAgdmFyIHBhcmFtcyA9IHt9O1xuICAgIHBhcmFtc1tlbnRpdHldID0gaWQ7XG5cbiAgICAkLmFqYXgoe1xuICAgICAgdXJsOiBSb3V0aW5nLmdlbmVyYXRlKHJvdXRlLCBwYXJhbXMpLFxuICAgICAgbWV0aG9kOiAnR0VUJyxcbiAgICAgIGRhdGFUeXBlOiAnaHRtbCdcbiAgICB9KVxuICAgIC5kb25lKGZ1bmN0aW9uKGRhdGEpIHtcbiAgICAgIHNob3dNb2RhbFdpbmRvdygkKGRhdGEpKTtcbiAgICB9KTtcbiAgfSk7XG5cbiAgJCgnLmRlbGV0ZS1idXR0b24nKS5vbignY2xpY2snLCBmdW5jdGlvbigpIHtcbiAgICB2YXIgcm91dGUgPSAkKHRoaXMpLmF0dHIoJ2RhdGEtcm5hbWUnKTtcbiAgICB2YXIgaWQgPSAkKHRoaXMpLmF0dHIoJ2RhdGEtaWQnKTtcbiAgICB2YXIgcGFyYW1zID0ge307XG4gICAgcGFyYW1zW2VudGl0eV0gPSBpZDtcblxuICAgICQuYWpheCh7XG4gICAgICB1cmw6IFJvdXRpbmcuZ2VuZXJhdGUocm91dGUsIHBhcmFtcyksXG4gICAgICBtZXRob2Q6ICdHRVQnLFxuICAgICAgZGF0YVR5cGU6ICdodG1sJ1xuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oZGF0YSkge1xuICAgICAgc2hvd01vZGFsV2luZG93KCQoZGF0YSkpO1xuICAgIH0pO1xuICB9KTtcblxuICBib2R5Lm9uKCdzaG93bi5icy5tb2RhbCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgdmFyIHRhZ1NlbGVjdG9yID0gJCh0aGlzKS5maW5kKChcIiNhcHBfYnVuZGxlX2Jvb2tfdHlwZV90YWdzXCIpKTtcbiAgICAkKHRhZ1NlbGVjdG9yKS5jaG9zZW4oe1xuICAgICAgIHNlYXJjaF9jb250YWluczogdHJ1ZSxcbiAgICAgICBwbGFjZWhvbGRlcl90ZXh0X211bHRpcGxlOiAnICBTZWxlY3QgdGFncydcbiAgICB9KTtcblxuICAgIHZhciBtb2RhbCA9ICQoZS50YXJnZXQpO1xuXG4gICAgbW9kYWwuZmluZCgnZm9ybScpLm9uKCdzdWJtaXQnLCBmdW5jdGlvbihlKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICBldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgdmFyIGZvcm0gPSAkKHRoaXMpO1xuICAgICAgJC5hamF4KHtcbiAgICAgICAgdHlwZTogZm9ybS5hdHRyKCdtZXRob2QnKSxcbiAgICAgICAgdXJsOiBmb3JtLmF0dHIoJ2FjdGlvbicpLFxuICAgICAgICBkYXRhOiBmb3JtLnNlcmlhbGl6ZSgpLFxuICAgICAgICBkYXRhVHlwZTogJ2h0bWwnXG4gICAgICB9KS5kb25lKGZ1bmN0aW9uKGRhdGEpIHtcbiAgICAgICAgaGlkZU1vZGFsV2luZG93KG1vZGFsKTtcbiAgICAgICAgaWYgKGRhdGEgPT09ICdTVUNDRVNTJykge1xuICAgICAgICAgIGxvY2F0aW9uLnJlbG9hZCgpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgIHNob3dNb2RhbFdpbmRvdygkKGRhdGEpKTtcbiAgICAgICAgfVxuICAgICAgfSk7XG4gICAgfSk7XG5cbiAgfSk7XG5cbiAgYm9keS5vbignaGlkZGVuLmJzLm1vZGFsJywgJy5tb2RhbCcsIGZ1bmN0aW9uICgpIHtcbiAgICAkKHRoaXMpLnJlbW92ZURhdGEoJ2JzLm1vZGFsJyk7XG4gICAgJCh0aGlzKS5yZW1vdmUoKTtcbiAgfSk7XG5cbiAgZnVuY3Rpb24gc2hvd01vZGFsV2luZG93KG1vZGFsKSB7XG4gICAgbW9kYWwubW9kYWwoJ3Nob3cnKTtcbiAgfVxuXG4gIGZ1bmN0aW9uIGhpZGVNb2RhbFdpbmRvdyhtb2RhbCkge1xuICAgIG1vZGFsLm1vZGFsKCdoaWRlJyk7XG4gIH1cbn0pO1xuIl19