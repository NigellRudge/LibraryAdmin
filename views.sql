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
           age_restricted,
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
           birth_date,
           status_id,
           s.name as 'status',
           IF(main_member_id is null,'Main Member','sub Member') as 'member_type'
    from members m left join genders g on m.gender_id = g.id left join status s on m.status_id = s.id;

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
    from authors author left join genders g on author.gender_id = g.id;

drop view if exists book_category_info;
create view book_category_info  as
    select bc.book_id,
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


drop view if exists membership_request_info;
create view membership_request_info as
    select r.id as 'id',
           m.birth_date as 'birth_date',
           m.address as 'address',
           m.phone_number as 'phone_number',
           IF(m.email is null,'No Email',m.email) as 'email',
           m.name as 'member',
           r.status_id,
           mt.name as 'membership_type',
           s.name as 'status',
           m.picture as 'member_picture',
           request_date,
           if(processed_date is null,'Not processed yet',request_date) as 'processed_date',
           membership_type_id
    from membership_requests r left join member_info m on r.member_id = m.id
        left join membership_types mt on r.membership_type_id = mt.id
        left join status s on r.status_id = s.id;


drop view if exists loan_info;
create view loan_info as
    select l.id as 'id',
           member_id,
           m.name as 'member',
           bi.title as 'book',
           bi.id as 'book_item_id',
           loan_date,
           expected_date,
           return_date,
           extended,
           l.status_id,
           if(return_date is null,if(now() > expected_date,'Late','normal'),'returned')as 'status'
    from loans l  left join member_info m on l.member_id = m.id left join book_item_info bi on l.book_item_id = bi.id;


drop view if exists invoice_info;
create view invoice_info as
    select i.id as 'id',
           m.name as 'member',
           i.member_id,
           i.invoice_type,
           it.name as 'type',
           i.total_amount,
           i.open_amount,
           i.invoice_date,
           i.status_id,
           CONCAT(invoice_date, ' $', total_amount) as 'name',
           s.name as 'status',
           i.paid,
           i.paid_date,
           i.payment_term
    from invoices i left join member_info  m on i.member_id = m.id
    left join invoice_types it on i.invoice_type = it.id
    left join status s on i.status_id = s.id;

drop view if exists payment_info;
create view payment_info as
    select p.id as 'id',
           invoice_id,
           i.member_id,
           concat('(',i.invoice_date,')', ' $',i.total_amount ) as 'invoice',
           m.name as 'member',
           amount,
           payment_date
    from payments p
        left join invoices i on p.invoice_id = i.id
        left join member_info m on i.member_id = m.id;
