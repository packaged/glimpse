Glimpse
=======

HTML Markup Helper

## Usage

   use Packaged\Glimpse\Core\HtmlTag;

#### Code

    echo HtmlTag::createTag('br');

#### Output

    <br />

#### Code

    echo HtmlTag::createTag('img',['src' => 'x.gif']);

#### Output

    <img src="x.gif" />


#### Code

    echo HtmlTag::create()
      ->setTag('div')
      ->setId('dog-tag')
      ->addClass('dogs', 'tag',['yellow','red'])
      ->setAttribute('title', 'Dog Tags')
      ->setContent('Hey There<a href="">');

#### Output

    <div id="dog-tag" class="dogs tag yellow red" title="Dog Tags">Hey There&lt;a href=&quot;&quot;&gt;</div>

