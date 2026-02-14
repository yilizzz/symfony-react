import React from "react";
import { useState, useEffect } from "react";
const ReadingList = () => {
    const [readings, setReadings] = useState([]);
    const [loading, setLoading] = useState(true);

    // 1. 获取数据
    const fetchReadings = async () => {
        try {
            const response = await fetch("/api/readings?order[createdAt]=desc");
            const data = await response.json();
            setReadings(data["member"] || []);
            setLoading(false);
        } catch (error) {
            console.error("加载失败:", error);
        }
    };

    useEffect(() => {
        fetchReadings();
    }, []);

    // 2. 删除逻辑
    const handleDelete = async (id) => {
        if (!confirm("确定要删除这条读数吗？")) return;

        try {
            const response = await fetch(`/api/readings/${id}`, {
                method: "DELETE",
            });
            if (response.ok) {
                // 刷新列表
                setReadings(readings.filter((item) => item.id !== id));
            }
        } catch (error) {
            alert("删除失败");
        }
    };

    if (loading) return <div>正在加载水表数据...</div>;
    return (
        <div className="table-responsive">
            <table className="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>日期</th>
                        <th>读数 (m³)</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    {readings.map((reading) => (
                        <tr key={reading.id}>
                            <td>{reading.id}</td>
                            <td>
                                {new Date(
                                    reading.createdAt
                                ).toLocaleDateString()}
                            </td>
                            <td>{reading.value}</td>
                            <td>
                                <button
                                    className="btn btn-danger btn-sm"
                                    onClick={() => handleDelete(reading.id)}
                                >
                                    删除
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};
export default ReadingList;
