drop view if exists book_info;
create view book_info as
    select books.id as'id',
           title,
           author_id,
           a.name as 'author',
           isbn,
           num_pages,
           publication_date,
           cover,
           short_description,
           (select count(*) from book_items where book_id = books.id) as 'num_copies'
    from books left join authors a on books.author_id = a.id;

drop view if exists author_books;
create view author_books as
    select author.id as 'id',
           author.name as 'author',
           book.title as 'book',
           book.id as 'book_id'
    from authors author left join book_info book on author.id = book.author_id;


drop view if exists member_info;
create view member_info as
    select m.id as 'id',
           concat(m.first_name, ' ', m.last_name) as 'name',
           year(curdate()) - year(birth_date) as age,
           g.name as 'gender',
           address,
           picture,
           email,
           gender_id,
           phone_number,
           birth_date
    from members m left join genders g on m.gender_id = g.id;

drop view if exists library_card_info;
create view library_card_info as
    select card.id as 'id',
           member.name,
           member_id,
           start_date,
           end_date
    from library_cards card left join member_info member on card.member_id = member.id;


drop view if exists author_info;
create view author_info as
    select author.id as 'id',
           author.name as 'name',
           gender_id,
           g.name as 'gender',
           (select count(*) from book_info where author_id = author.id) as 'num_books'
    from authors author left join genders g on author.gender_id = g.id

drop view if exists book_category_info;
create view book_category_info  as
    select cbc.book_id,
           b.title as 'title',
           c.name as 'category',
           bc.category_id
    from book_categories bc left join books b  on b.id = bc.book_id left join categories c on bc.category_id = c.id order by b.title;

drop view if exists category_info;
create view category_info as
    select  categories.id,
            categories.name,
            categories.code,
            (select count(*) from book_categories where category_id = categories.id) as 'num_books'
    from categories;


drop view if exists book_item_info;
create view book_item_info as
    select item.id as 'id',
           uid,
           book_id,
           book.title as 'title',
           author.name as 'author',
           author_id,
           condition_id,
           status_id,
           `condition`.name as 'condition',
           status.name as 'status'
from book_items item left join books book on item.book_id = book.id
    left join authors author on book.author_id = author.id
    left join `condition` on item.condition_id = `condition`.id
    left join `status` on item.status_id = `status`.id;
