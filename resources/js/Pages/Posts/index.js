import { Component } from "react";
import { PostService } from "../../Services/PostService";

export default class PostsIndex extends Component {

    constructor(props) {
        super(props);

        this.state = {
            posts: [],
            searchCriteria: ''
        }
        this.handleSearch = this.debounce(this.handleSearch.bind(this), 1000);
    }

    fetchPosts(page = 1, searchCriteria = '') {
        PostService.fetchPosts(page, searchCriteria).then(posts => {
            this.setState({ posts });
        }).catch(error => {
            console.error("There was an error fetching the posts: ", error);
        });
    }


    pageChanged(url) {
        const fullUrl = new URL(url);
        const page = fullUrl.searchParams.get('page')

        this.fetchPosts(Number(page));
    }

    componentDidMount() {
        this.fetchPosts();
    }

    renderPaginatorLinks() {
        return this.state.posts.meta.links.map((link, index) => {
            const isDisabled = link.url === null;
            const isActive = link.active;
            const buttonClass = `relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 first:rounded-l-md last:rounded-r-md ${isDisabled ? 'opacity-50 cursor-not-allowed' : ''} ${isActive ? 'bg-blue-500 text-white' : ''}`;

            return (
                <button key={index}
                        onClick={() => !isDisabled && this.pageChanged(link.url)}
                        dangerouslySetInnerHTML={{__html: link.label}}
                        className={buttonClass}
                        disabled={isDisabled} />
            );
        });
    }

    handleSearch(event) {
        const searchCriteria = event.target.value;
        this.setState({ searchCriteria }, () => {
            this.fetchPosts(1, searchCriteria);
        });
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }



    renderPagination() {
        return (
            <nav role="navigation" aria-label="Pagination Navigation" className="flex items-center justify-between">
                <div className="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div className="">
                        <p className="text-sm text-gray-700 leading-5">
                            Showing
                            <span>
                                <span className="font-medium"> {this.state.posts.meta.from} </span>
                                to
                                <span className="font-medium"> {this.state.posts.meta.to} </span>
                            </span>
                            of
                            <span className="font-medium"> {this.state.posts.meta.total} </span>
                            results
                        </p>
                    </div>

                    <div className="justify-end">
                        <span className="ml-3 relative z-0 inline-flex shadow-sm rounded-md">
                            {this.renderPaginatorLinks()}
                        </span>
                    </div>
                </div>
            </nav>
        );
    }

    render() {
        if (!('data' in this.state.posts)) return;
        return (
            <div className="relative overflow-x-auto">
                <h1 className="text-2xl font-semibold text-gray-700 dark:text-gray-200">Posts</h1>
                <div className="mt-4 mb-4">
                    <input onChange={this.handleSearch} type="text" className="bg-gray-50 border
                    border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                    dark:focus:border-blue-500"
                           placeholder="Search anything"/>
                </div>
                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" className="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Title
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Categories (preview)
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Content
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Creation date
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {this.state.posts.data.map(post => {
                        return (
                            <tr key={post.id}>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    {post.id}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    {post.title}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    {post.categories.map((category, index) => (
                                        <span key={index}
                                              className="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 mb-1 inline-block">
                                            {category}
                                        </span>
                                    ))}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    {post.content}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    {post.created_at}
                                </td>
                            </tr>
                        );
                    })}
                    </tbody>
                </table>
                <div className="">
                    <div className="mt-4">
                        { this.renderPagination() }
                    </div>
                </div>
            </div>
        );
    }
}

