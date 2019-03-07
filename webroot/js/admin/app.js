/**
 * 后台拓展插件
 */
+(function($) {
  'use strict'

  var ProblemContent = function(element, options) {
    this.$element = $(element)
    this.options = options
    this.tools = this.TOOLS()
    this.$tbody = this.$element.find('> tbody')
    if (!this.$tbody.length) {
      this.$tbody = $('<tbody></tbody>')
      this.$element.append(this.$tbody)
    }
    this.$row = ''
  }

  ProblemContent.DEFAULTS = {
    letterSelector: 'select.item-letter',
    addSelector: '.item-add', // 添加按钮
    delSelector: '.item-del' // 删除按钮
  }

  ProblemContent.prototype.TOOLS = function() {
    var that = this
    return {
      doAdd: function() {
        var $table = that.$element
        $table.on('click', that.options.addSelector, function(e) {
          e.preventDefault()
          that.add($table, 1, $table.find(that.options.letterSelector).val())
        })
      },
      doDel: function() {
        var $table = that.$element
        $table.on('click', that.options.delSelector, function(e) {
          e.preventDefault()
          that.del($(this).closest('tr'))
        })
      }
    }
  }

  ProblemContent.prototype.init = function() {
    var that = this
    var tool = this.tools
    var $row = that.$element.find('> thead tr[data-content]')
    that.$row = $row.clone().removeClass('hidden').removeAttr('data-content')
    that.$row.find('input[type="checkbox"]').attr('data-toggle', 'icheck')
    $row.remove()
    tool.doAdd()
    tool.doDel()

  }

  /**
   * 添加行
   * @param $table
   * @param num
   * @param letter
   */
  ProblemContent.prototype.add = function($table, num, letter) {
    num = num || 1
    var $tbody = $table.find('> tbody')
    var $row = this.$row
    for (var i = 0; i < num; i++) {
      var $addRow = $row.clone()

      $addRow.find(':input, a, label, div').each(function () {
        var $child = $(this)

        var name = $child.attr('name')

        var fors = $child.attr('for')

        var id = $child.attr('id')

        var href = $child.attr('href')

        var group = $child.attr('data-group')

        var title = $child.attr('title')

        if (name) $child.attr('name', name.replaceSuffix(letter))
        if (fors) $child.attr('for', fors.replaceSuffix(letter))
        if (id) $child.attr('id', id.replaceSuffix(letter).replaceSuffix2(letter))
        if (href) $child.attr('href', href.replaceSuffix(letter))

        if ($child.is('div') && title) {
          $child.text(title.replace('#index#', letter))
        }
      })
      $addRow.appendTo($tbody)
      $addRow.initui()
    }
  }

  /**
   * 删除指定行
   * @param $row
   */
  ProblemContent.prototype.del = function($row) {
    $row.remove()
  }

  function Plugin(option) {
    return this.each(function() {
      var $this = $(this)
      var options = $.extend({}, ProblemContent.DEFAULTS, $this.data(), typeof option === 'object' && option)
      var data = new ProblemContent(this, options)
      data.init()
    })
  }

  var old = $.fn.problemcontent

  $.fn.problemcontent = Plugin
  $.fn.problemcontent.Constructor = ProblemContent

  $.fn.problemcontent.noConflict = function() {
    $.fn.problemcontent = old
    return this
  }

  /**
   * 实例化
   */
  $(document).on(BJUI.eventType.initUI, function(e) {
    var $this = $(e.target).find('table[data-toggle="problemcontent"]')

    if (!$this.length) return

    Plugin.call($this)
  })
})(jQuery)

