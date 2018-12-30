/**
 * Created by Administrator on 2016/9/12.
 */

/*
 * tabs_name:用于触发事件的标签的类名；
 * contents_name:内容容器的类名；
 * tabs_checked_style:标签为选中状态时的样式；
 * contents_checked_style:内容容器为选中状态时的样式；
 *
 * classList.toggle();
 * 检查元素的类名列表中是否有指定的类名，如果有则移除，如果没有则添加；
 * */
function Tabs(tabs_name, contents_name, tabs_checked_style, contents_checked_style) {
    var tabs = document.querySelectorAll(tabs_name),
        contents = document.querySelectorAll(contents_name),
        e_mark = 0;
    for (var i = 0, len = tabs.length; i < len; i++) {
        tabs[i].num = i;
        tabs[i].onclick = function () {
            tabs[e_mark].classList.toggle(tabs_checked_style);
            tabs[this.num].classList.toggle(tabs_checked_style);
            contents[e_mark].classList.toggle(contents_checked_style);
            contents[this.num].classList.toggle(contents_checked_style);
            e_mark = this.num;
        };
    }
}